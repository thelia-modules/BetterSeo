<?php

namespace BetterSeo\Controller;

use BetterSeo\BetterSeo;
use BetterSeo\Form\ConfigurationForm;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Thelia\Controller\Admin\AdminController;
use Thelia\Core\Template\ParserContext;
use Thelia\Form\Exception\FormValidationException;

#[Route('/admin/module/BetterSeo', name: 'betterseo_config_')]
class ConfigurationController extends AdminController
{
    #[Route('/configuration', name: 'configuration')]
    public function saveConfiguration(ParserContext $parserContext): RedirectResponse|Response|null
    {
        $form = $this->createForm(ConfigurationForm::getName());
        try {
            $data = $this->validateForm($form)->getData();

            BetterSeo::setConfigValue(BetterSeo::BETTER_SE0_LIMIT_CONFIG_KEY, $data["category_limit"]);

            return $this->generateSuccessRedirect($form);
        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }

        $form->setErrorMessage($error_message);

        $parserContext
            ->addForm($form)
            ->setGeneralError($error_message);

        return $this->generateErrorRedirect($form);
    }
}