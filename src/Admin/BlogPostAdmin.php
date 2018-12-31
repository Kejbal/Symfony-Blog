<?php
// src/Admin/BlogPostAdmin.php
namespace App\Admin;

use App\Entity\Category;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogPostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', TextType::class)
            ->add('body', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('draft', ChoiceType::class, array(
                'choices' => array(
                    'Yes' => true,
                    'No' => false,
                )));

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        // ... configure $listMapper
    }
}
