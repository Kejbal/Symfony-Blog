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

        $entity->setSlug($entity->getName());
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
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

}