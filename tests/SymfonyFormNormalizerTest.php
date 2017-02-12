<?php

namespace Tests;

use AndreySerdjuk\SymfonyFormNormalizer\SymfonyFormNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Forms;
use Tests\Form\TestFormType;

/**
 * Class SymfonyFormNormalizerTest
 * @package AndreySerdjuk\SymfonyFormNormalizer\Tests
 */
class SymfonyFormNormalizerTest extends TestCase
{
    public function testNormilize()
    {
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        $form = $formFactory->create(TestFormType::class);
        $view = $form->createView();
        $normalizer = new SymfonyFormNormalizer();
        $data = $normalizer->normalize($view);

        $this->assertTrue(is_array($data));
        $this->assertArrayHasKey('children', $data);
        $this->assertCount(5, $data['children']);
    }
}
