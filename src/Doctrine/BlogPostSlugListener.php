<?php
namespace App\Doctrine;

use App\Entity\BlogPost;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class BlogPostSlugListener implements EventSubscriber
{

    public function getSubscribedEvents()
    {

        return ['prePersist', 'preUpdate'];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof BlogPost) {
            return;
        }

        $em = $args->getEntityManager();

        $entity->setSlug($entity->getTitle());

        $i=0;
        do {
            if ($entity->getId()) {
                $post_row=$em->createQuery('SELECT bp FROM App:BlogPost bp WHERE bp.slug=:slug AND  bp.id!=:id ORDER BY bp.name ASC')->setParameter('slug', $entity->getSlug())->setParameter('id', $entity->getId())
                ->getResult();
            } else {
                $post_row=$em->createQuery('SELECT bp FROM App:BlogPost bp WHERE bp.slug=:slug ORDER BY bp.name ASC')->setParameter('slug', $entity->getSlug())
                ->getResult();
            }

            if (empty($post_row)) {
                break;
            }

            $entity->setSlug($entity->getTitle().'-'.$i);

            $i++;

        } while(!empty($post_row));

    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof BlogPost) {
            return;
        }

        $entity->setSlug($entity->getTitle());

        // necessary to force the update to see the change
        $em = $args->getEntityManager();

        $i=0;
        do {
            if ($entity->getId()) {
                $post_row=$em->createQuery('SELECT bp FROM App:BlogPost bp WHERE bp.slug=:slug AND  bp.id!=:id ORDER BY bp.id ASC')->setParameter('slug', $entity->getSlug())->setParameter('id', $entity->getId())
                ->getResult();
            } else {
                $post_row=$em->createQuery('SELECT bp FROM App:BlogPost bp WHERE bp.slug=:slug ORDER BY bp.id ASC')->setParameter('slug', $entity->getSlug())
                ->getResult();
            }

            if (empty($post_row)) {
                break;
            }

            $entity->setSlug($entity->getTitle().'-'.$i);

            $i++;

        } while(0);

        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

}