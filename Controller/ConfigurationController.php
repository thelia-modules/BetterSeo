<?php

/*
 * This file is part of the Thelia package.
 * http://www.thelia.net
 *
 * (c) OpenStudio <info@thelia.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BetterSeo\Controller;

use BetterSeo\BetterSeo;
use BetterSeo\Form\CategoryLimitForm;
use BetterSeo\Form\StoreSeoForm;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Thelia\Controller\Admin\AdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Template\ParserContext;
use Thelia\Form\Exception\FormValidationException;

#[Route('/admin/module/BetterSeo', name: 'betterseo_config_')]
class ConfigurationController extends AdminController
{
    #[Route('/configuration/category', name: 'category_configuration', methods: 'POST')]
    public function saveCategoryConfiguration(ParserContext $parserContext): RedirectResponse|Response|null
    {
        $form = $this->createForm(CategoryLimitForm::getName());
        try {
            $data = $this->validateForm($form)->getData();

            BetterSeo::setConfigValue(BetterSeo::BETTER_SE0_LIMIT_CONFIG_KEY, $data['category_limit']);

            return $this->generateSuccessRedirect($form);
        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
        }

        $form->setErrorMessage($error_message);

        $parserContext
            ->addForm($form)
            ->setGeneralError($error_message);

        return $this->generateErrorRedirect($form);
    }

    #[Route('/configuration/store', name: 'store_configuration', methods: 'POST')]
    public function saveStoreConfiguration(ParserContext $parserContext): RedirectResponse|Response|null
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['BetterSeo'], AccessManager::UPDATE)) {
            return $response;
        }

        $baseForm = $this->createForm(StoreSeoForm::getName());

        $errorMessage = null;

        // Get current edition language locale
        $locale = $this->getCurrentEditionLocale();

        try {
            $form = $this->validateForm($baseForm);
            $data = $form->getData();

            // Save data
            BetterSeo::setConfigValue('title', $data['title'], $locale);
            BetterSeo::setConfigValue('description', $data['description'], $locale);
            BetterSeo::setConfigValue('keywords', $data['keywords'], $locale);
        } catch (FormValidationException $ex) {
            // Invalid data entered
            $errorMessage = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            // Any other error
            $errorMessage = $this->getTranslator()->trans('Sorry, an error occurred: %err', ['%err' => $ex->getMessage()], BetterSeo::DOMAIN_NAME, $locale);
        }

        if (null !== $errorMessage) {
            // Mark the form as with error
            $baseForm->setErrorMessage($errorMessage);

            // Send the form and the error to the parser
            $this->getParserContext()
                ->addForm($baseForm)
                ->setGeneralError($errorMessage)
            ;
        } else {
            $this->getParserContext()
                ->set('success', true)
            ;
        }

        return $this->generateErrorRedirect($baseForm);
    }
}
