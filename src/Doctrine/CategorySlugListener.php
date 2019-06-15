<?php
namespace App\Doctrine;

use App\Entity\Category;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CategorySlugListener implements EventSubscriber
{

    public function getSubscribedEvents()
    {

        return ['prePersist', 'preUpdate'];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Category) {
            return;
        }

        $em = $args->getEntityManager();

        $entity->setSlug($entity->getName());

        $i = 0;
        do {

            $categoryRow = $em->createQuery('SELECT c FROM App:Category c WHERE c.slug=:slug ORDER BY c.name ASC')->setParameter('slug', $entity->getSlug())
                ->getResult();

            if (empty($categoryRow)) {
                break;
            }

            $entity->setSlug($entity->getName() . '-' . $i);

            $i++;

        } while (!empty($categoryRow));

    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Category) {
            return;
        }

        $entity->setSlug($entity->getName());

        // necessary to force the update to see the change
        $em = $args->getEntityManager();

        $i = 0;
        do {

            $categoryRow = $em->createQuery('SELECT c FROM App:Category c WHERE c.slug=:slug ORDER BY c.name ASC')->setParameter('slug', $entity->getSlug())
                ->getResult();

            if (empty($categoryRow)) {
                break;
            }

            $entity->setSlug($entity->getName() . '-' . $i);

            $i++;

        } while (0);

        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

}