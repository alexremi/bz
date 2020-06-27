<?php

namespace App\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class ClassifyCorollaCommand.
 */
class ClassifyCorollaCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var string
     */
    private $corollaRecognizerDirPath;

    /**
     * @param ContainerInterface $container
     * @param string|null        $name
     */
    public function __construct(ContainerInterface $container, string $name = null)
    {
        parent::__construct($name);

        $this->container  = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Classify corolla image')
            ->setName('app:corolla:classify')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->corollaRecognizerDirPath = $this->container->getParameter('corolla_recognizer_dir');

        try {
            $this->runImageToCsvProcess();
            $resultClass = $this->runClassifyProcess();
        } catch (Exception $e) {
            $this->container->get('logger')->critical($e->getMessage());

            return null;
        }

        echo "Success!\nClass: {$resultClass}";

        return $resultClass;
    }

    /**
     * Image to csv process.
     */
    private function runImageToCsvProcess()
    {
        $imageToCsvFilePath = "{$this->corollaRecognizerDirPath}image_to_csv.py";
        $imageToCsvProcess  = new Process(["python", $imageToCsvFilePath]);
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
        $mainFilePath = "{$this->corollaRecognizerDirPath}main.py";
        $mainProcess  = new Process(["python3", $mainFilePath]);
        $mainProcess->run();

        if (!$mainProcess->isSuccessful()) {
            throw new ProcessFailedException($mainProcess);
        }

        return $mainProcess->getOutput();
    }
}
