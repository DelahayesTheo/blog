<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\PostType;

class DataCreationCommand extends ContainerAwareCommand
{
    // Contains type of post, article or page ATM
    private static $postTypeToImport = array(
        array("name" => "Article", "identifier" => "ARTICLE"),
        array("name" => "Page", "identifier" => "PAGE")
    );

    protected function configure()
    {
        $this
            ->setName('app:init-datas')
            ->setDescription('Insert base data to the database')
            ->setHelp('This command insert required data to make this app working, use it only one time');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this
            ->getContainer()
            ->get("doctrine")
            ->getManager();

        $output->writeln("=== Insert post type data ===");
        $postTypeRepo = $em->getRepository("AppBundle:PostType");
        $insertedPostTypeCount = 0;

        foreach (self::$postTypeToImport as $onePostTypeToImport){
            if ($postTypeRepo->findOneByIdentifier($onePostTypeToImport["identifier"]) === null) {
                $postType = new PostType();
                $postType->setName($onePostTypeToImport["name"]);
                $postType->setIdentifier($onePostTypeToImport["identifier"]);
                $em->persist($postType);
                $insertedPostTypeCount++;
            }
        }

        if ($insertedPostTypeCount > 0) {
            $em->flush();
        }

        $output->writeln("=== Done - added ". $insertedPostTypeCount ." ===");
    }
}