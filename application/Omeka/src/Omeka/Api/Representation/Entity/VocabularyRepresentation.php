<?php
namespace Omeka\Api\Representation\Entity;

class VocabularyRepresentation extends AbstractEntityRepresentation
{
    public function getControllerName()
    {
        return 'vocabulary';
    }

    public function getJsonLd()
    {
        $entity = $this->getData();
        return array(
            'o:namespace_uri' => $entity->getNamespaceUri(),
            'o:prefix'        => $entity->getPrefix(),
            'o:label'         => $entity->getLabel(),
            'o:comment'       => $entity->getComment(),
            'o:owner'         => $this->getReference(
                null,
                $entity->getOwner(),
                $this->getAdapter('users')
            ),
        );
    }

    public function prefix()
    {
        return $this->getData()->getPrefix();
    }

    public function namespaceUri()
    {
        $namespaceUri = $this->getData()->getNamespaceUri();
        if ('omeka' == $namespaceUri) {
            // If this is the custom vocabulary, dynamically mint the namespace
            // for this Omeka instance.
            $url = $this->getViewHelper('url');
            $namespaceUri = $url(
                'instance_namespace',
                array(),
                array('force_canonical' => true)
            ) . '#';
        }
        return $namespaceUri;
    }

    public function comment()
    {
        return $this->getData()->getComment();
    }

    public function label()
    {
        return $this->getData()->getLabel();
    }

    /**
     * {@inheritDoc}
     */
    public function properties()
    {
        $properties = array();
        $propertyAdapter = $this->getAdapter('properties');
        foreach ($this->getData()->getProperties() as $propertyEntity) {
            $properties[] = $propertyAdapter->getRepresentation(
                null, $propertyEntity
            );
        }
        return $properties;
    }
    
     public function resourceClasses()
     {
        $resourceClasses = array();
        $resourceClassAdapter = $this->getAdapter('resource_classes');
        foreach ($this->getData()->getResourceClasses() as $resourceClass) {
            $resourceClasses[] = $resourceClassAdapter->getRepresentation(
                null, $resourceClass
            );
        }
        return $resourceClasses;
     }
}
