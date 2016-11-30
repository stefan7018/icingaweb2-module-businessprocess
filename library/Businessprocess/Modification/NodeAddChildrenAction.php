<?php

namespace Icinga\Module\Businessprocess\Modification;

use Icinga\Module\Businessprocess\BpNode;
use Icinga\Module\Businessprocess\BusinessProcess;

class NodeAddChildrenAction extends NodeAction
{
    protected $children = array();

    protected $preserveProperties = array('children');

    /**
     * @inheritdoc
     */
    public function appliesTo(BusinessProcess $bp)
    {
        $name = $this->getNodeName();

        if (! $bp->hasNode($name)) {
            return false;
        }

        return $bp->getNode($name) instanceof BpNode;
    }

    /**
     * @inheritdoc
     */
    public function applyTo(BusinessProcess $bp)
    {
        /** @var BpNode $node */
        $node = $bp->getNode($this->getNodeName());
        $existing = $node->getChildNames();
        foreach ($this->children as $name) {
            if (! in_array($name, $existing)) {
                $existing[] = $name;
            }
        }
        $node->setChildNames($existing);

        return $this;
    }

    /**
     * @param array|string $children
     * @return $this
     */
    public function setChildren($children)
    {
        if (is_string($children)) {
            $children = array($children);
        }
        $this->children = $children;
        return $this;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }
}