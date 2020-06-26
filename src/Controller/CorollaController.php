<?php


namespace App\Controller;

use App\Command\ClassifyCorollaCommand;
use App\Entity\Corolla;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
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
     * @param Request $request
     * @param KernelInterface $kernel
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function getClass(Request $request, KernelInterface $kernel)
    {
        /** @var File $file */
        $file = $request->files->get('file');
        if (!$file) {
            throw new BadRequestHttpException();
        }

        $uploadsDir           = $this->getParameter('uploads');
        $corollaRecognizerDir = $this->getParameter('corolla_recognizer_dir');

        $file->move("{$corollaRecognizerDir}images_check/0", "{$file->getFilename()}.{$file->guessExtension()}");

        $application = new Application($kernel);
        $application->setAutoExit(false);
        $input1  = new ArrayInput(['command' => 'app:corolla:classify']);
        $output1 = new BufferedOutput();
        $application->run($input1, $output1);
        $content1 = $output1->fetch();

        $checkbox = $request->request->get('checkbox');
//        if (json_decode($checkbox)) {

//            $corolla = new Corolla();



//            $corolla->setCorollaClass();
//            $corolla->setImage();

//        }

        return new JsonResponse();
    }
}