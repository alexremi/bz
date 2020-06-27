<?php


namespace App\Controller;

use App\Command\ClassifyCorollaCommand;
use App\Entity\Corolla;
use App\Entity\Klas;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/corolla")
 */
class CorollaController extends AbstractController
{
    /**
     * @Route("/", name="corolla", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function corollaAction(Request $request): Response
    {
        return $this->render('corolla/index.html.twig');
    }

    /**
     * @Route("/classifier", name="corolla_classifier", methods={"POST"})
     *
     * @param Request         $request
     * @param LoggerInterface $logger
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function getClass(Request $request, LoggerInterface $logger)
    {
        /** @var File $file */
        $file = $request->files->get('file');
        if (!$file) {
            throw new BadRequestHttpException();
        }

        $uploadsDir           = $this->getParameter('uploads');
        $corollaRecognizerDir = $this->getParameter('corolla_recognizer_dir');
        $imagesCheck0Dir      = "{$corollaRecognizerDir}images_check/0/";
        $checkFile            = "{$corollaRecognizerDir}csv/check.csv";
        $fileName             = "{$file->getFilename()}.{$file->guessExtension()}";

        $file->move($imagesCheck0Dir, $fileName);

        try {
            $this->runImageToCsvProcess();
            $className = $this->runClassifyProcess();
        } catch (Exception $e) {
            $message = $e->getMessage();
            $logger->critical($message);

            throw new Exception($message);
        }

        $filesystem = new Filesystem();
        $filesystem->remove($checkFile);

        $checkbox = json_decode($request->request->get('checkbox'));
        if ($checkbox) {
            $file->move($uploadsDir, "{$className}_{$fileName}"); // TODO: change
            $filePath = "{$uploadsDir}{$className}_{$fileName}";

            $corolla = new Corolla();
            $corolla->setImage($filePath);

            $em    = $this->getDoctrine()->getManager();
            $class = $em->getRepository(Klas::class)->findOneBy(['name' => $className]);
            if (!$class) {
                $class = new Klas();
                $class->setName($className);
                $em->persist($class);
            }
            $corolla->setCorollaClass($class);

            try {
                $em->persist($corolla);
                $em->flush();
            } catch (Exception $e) {
                $message = "Couldn't save corolla: {$e->getMessage()}";
                $logger->critical("Couldn't save corolla: {$message}");

                throw new Exception($message);
            }

        } else {
            $filesystem->remove($imagesCheck0Dir . $fileName);
        }

        return new JsonResponse(['class' => $className]);
    }

    /**
     * Image to csv process.
     */
    private function runImageToCsvProcess()
    {
        $imageToCsvFilePath = "{$this->getParameter('corolla_recognizer_dir')}image_to_csv.py";
        $imageToCsvProcess  = new Process(["python", $imageToCsvFilePath], '../');
        $imageToCsvProcess->run();

        if (!$imageToCsvProcess->isSuccessful()) {
            throw new ProcessFailedException($imageToCsvProcess);
        }
    }

    /**
     * Get class of image.
     *
     * @return string
     */
    private function runClassifyProcess()
    {
        $mainFilePath = "{$this->getParameter('corolla_recognizer_dir')}main.py";
        $mainProcess  = new Process(["python3", $mainFilePath], '../');
        $mainProcess->run();

        if (!$mainProcess->isSuccessful()) {
            throw new ProcessFailedException($mainProcess);
        }

        return $mainProcess->getOutput();
    }
}