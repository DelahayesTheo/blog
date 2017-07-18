<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\PostType;

class DataCreationCommand extends ContainerAwareCommand
{
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

        // Check if we already has article type ?
        if ($postTypeRepo->findOneByIdentifier("ARTICLE") === null) {
            $postType = new PostType();
            $postType->setName("Article");
            $postType->setIdentifier("ARTICLE");
            $em->persist($postType);
            $insertedPostTypeCount++;
        }

        // Check if we already has post type ?
        if ($postTypeRepo->findOneByIdentifier("PAGE") === null) {
            $postType = new PostType();
            $postType->setName("Page");
            $postType->setIdentifier("PAGE");
            $em->persist($postType);
            $insertedPostTypeCount++;
        }

        if ($insertedPostTypeCount > 0) {
            $em->flush();
        }

        $output->writeln("=== Done - added ". $insertedPostTypeCount ." ===");
    }
}