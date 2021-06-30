<?php

namespace BetterSeo\Smarty\Plugins;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Thelia\Core\Template\Element\Exception\ElementNotFoundException;
use Thelia\Log\Tlog;
use Thelia\Model\Product;
use TheliaSmarty\Template\Plugins\TheliaLoop;
use TheliaSmarty\Template\SmartyPluginDescriptor;

class BetterSeoLoopPlugin extends TheliaLoop
{
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor('function', 'BetterSeoMicroDataLoop', $this, 'betterSeoMicroDataLoop'),
        );
    }

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    /**
     * @param $params
     * @return array|int
     * @throws \ReflectionException
     */
    public function betterSeoMicroDataLoop($params)
    {
        $name = $this->getParam($params, 'name');

        $type = $this->getParam($params, 'type');

        if (null == $type) {
            throw new \InvalidArgumentException(
                $this->translator->trans("Missing 'type' parameter loop arguments")
            );
        }

        try {

            $loop = $this->createLoopInstance($params);

            self::$pagination[$name] = null;

            $loopResults = clone($loop->exec(self::$pagination[$name]));
            $productIds = [];

            /** @var Product $result */
            foreach ($loopResults->getResultDataCollection() as $result){
                $productIds[] = $result->getId();
            }

            return $productIds;
        } catch (ElementNotFoundException $ex) {

            if ($this->isDebugActive) {
                throw $ex;
            }

            Tlog::getInstance()->error($ex->getMessage());

            return 0;
        }
    }
}