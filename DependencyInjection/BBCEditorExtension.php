<?php

namespace MPeters\BBCEditorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Registration of the extension via DI.
 *
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2011 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class BBCEditorExtension extends Extension
{
    /**
     * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::load()
     * @param array                                                   $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('editor.xml');

		$container->setParameter('bbceditor.enable'           , $config['enable']);
		$container->setParameter('bbceditor.base_path'        , isset($config['base_path'])         ? $config['base_path']         : null);
		$container->setParameter('bbceditor.js_path'          , isset($config['js_path'])           ? $config['js_path']           : null);

		$templatingEngines = $container->getParameter('templating.engines');

		$templateTypes = Array('php'  => 'templating.helper.form.resources',
		                       'twig' => 'twig.form.resources'
		);

		foreach($templateTypes as $templateType => $templateParameter) {
			if (in_array($templateType, $templatingEngines)) {
				$container->setParameter($templateParameter,
					array_merge(
						$container->hasParameter($templateParameter) ? $container->getParameter($templateParameter) : array(),
						array('BBCEditorBundle:Form'.($templateType == 'twig' ? ':bbc_editor_widget.html.twig' : ''))
					)
				);
			}
		}
	}
}
