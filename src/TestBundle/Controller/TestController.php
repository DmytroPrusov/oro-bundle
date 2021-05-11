<?php
namespace TestBundle\Controller;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use TestBundle\Entity\Test;

class TestController extends Controller
{

    /**
     * @Route(
     *      "/{_format}",
     *      name="oro_test_index",
     *      requirements={"_format"="html|json"},
     *      defaults={"_format" = "html"}
     * )
     * @AclAncestor("oro_test_view")
     * @Template
     */
    public function indexAction()
    {
        return array('gridName' => 'items-grid');
    }

    /**
     * Create item form
     *
     * @Route("/create", name="oro_test_create")
     * @Acl(
     *      id="oro_test_create",
     *      type="entity",
     *      permission="CREATE",
     *      class="TestBundle:Test"
     * )
     * @Template("TestBundle:Test:update.html.twig")
     */
    public function createAction()
    {
        return $this->update();
    }

    /**
     * @param Test $entity
     * @return array
     */
    protected function update(Test $entity = null)
    {
        if (!$entity) {
            $entity = $this->getManager()->createEntity();
        }

        return $this->get('oro_form.model.update_handler')->update(
            $entity,
            $this->get('oro_test.form.item'),
            $this->get('translator')->trans('oro.test.controller.account.saved.message'),
            $this->get('oro_test.form.handler.item')
        );
    }

    /**
     * @return ApiEntityManager
     */
    protected function getManager()
    {
        return $this->get('oro_account.account.manager.api');
    }

}