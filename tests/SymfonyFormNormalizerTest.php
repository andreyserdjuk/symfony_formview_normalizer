<?php

namespace Tests;

use AndreySerdjuk\SymfonyFormNormalizer\DelegatingSymfonyFormNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Templating\TemplatingExtension;
use Symfony\Component\Form\Extension\Templating\TemplatingRendererEngine;
use Symfony\Component\Form\FormFactoryBuilder;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\Forms;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Tests\Form\TestFormType;

/**
 * Class SymfonyFormNormalizerTest
 * @package AndreySerdjuk\SymfonyFormNormalizer\Tests
 */
class SymfonyFormNormalizerTest extends TestCase
{
    public function testNormilize()
    {
        $builder = new FormFactoryBuilder();
//        $coreExtension = new CoreExtension();
//        $builder->addExtension(new CoreExtension());
//
//        $formFactory = Forms::createFormFactoryBuilder()
//            ->addExtension(new HttpFoundationExtension())
//            ->getFormFactory();
//
//        $form = $formFactory->create(TestFormType::class);
//        $view = $form->createView();
//        $normalizer = new DelegatingSymfonyFormNormalizer();
//        $data = $normalizer->normalize($view);
//
//        $this->assertTrue(is_array($data));
//        $this->assertArrayHasKey('children', $data);
//        $this->assertCount(5, $data['children']);



    }

    public function testTemplatingEngine()
    {
        $engine = new PhpEngine(
            new TemplateNameParser(),
            new FilesystemLoader([
                __DIR__.'/../src/views/%name%',
                __DIR__.'/../vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/%name%',
            ])
        );
        $engine->set(new SlotsHelper());
//        $engine->set(new FormHelper(new FormRenderer(
//            new TemplatingRendererEngine($engine)
//        )));

        $builder = Forms::createFormFactoryBuilder()
            ->addExtension(
                new TemplatingExtension(
                    $engine,
//                    new PhpEngine(
//                        new TemplateNameParser(),
//                        new FilesystemLoader([])
//                    ),
                    null,
                    [
                        'FrameworkBundle:Form',
                        'FrameworkBundle:FormTable',
                    ]
                )
            );
        $form = $builder->getFormFactory()->createBuilder()
            ->add('id', TextType::class)
            ->getForm()
        ;
        $form = $form->createView();


        $output = $engine->render('page.html.php', ['name' => 'Andrew', 'form' => $form]);

        $this->assertEquals('<h1>hello, Andrew</h1>', $output);
    }

    public function test2()
    {
        $loader = new FilesystemLoader(array());
        $engine = new PhpEngine(new TemplateNameParser(), $loader);
        $tre = new TemplatingRendererEngine($engine, array(
//            __DIR__ . '/../src/views/',
            __DIR__.'/../vendor/symfony/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Form/%name%',
        ));
        $renderer = new FormRenderer($tre);

        $factory = Forms::createFormFactoryBuilder()
//            ->addExtension(new \Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension())
            ->getFormFactory();
        $builder = $factory->createBuilder(FormType::class, null, array('action' => '#'))
            ->add('name', TextType::class)
            ->add('submit', SubmitType::class, array('label' => 'Hello world!'));
        $form = $builder->getForm();

        $output = $renderer->renderBlock($form->createView(), 'form');
        $a=1;
    }
}
