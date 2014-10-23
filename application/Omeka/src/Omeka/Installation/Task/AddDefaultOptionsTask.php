<?php
namespace Omeka\Installation\Task;

use Omeka\Installation\Manager;
use Omeka\Service\Paginator;

class AddDefaultOptionsTask implements TaskInterface
{
    protected $defaultOptions = array(
        'pagination_per_page' => Paginator::PER_PAGE,
    );

    public function perform(Manager $manager)
    {
        $options = $manager->getServiceLocator()->get('Omeka\Options');
        foreach ($this->defaultOptions as $id => $value) {
            $options->set($id, $value);
        }
    }
}
