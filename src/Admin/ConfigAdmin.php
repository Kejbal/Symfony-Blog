<?php
// src/Admin/CategoryAdmin.php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\GroupConfig;

class ConfigAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('base', TextType::class);
        $formMapper->add('value', TextType::class)
            ->add('group_config', EntityType::class, [
                'class' => GroupConfig::class,
                'choice_label' => 'name',
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('base');
        $datagridMapper->add('value');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('base');
        $listMapper->addIdentifier('value');
    }
}