<?php
    return array(
        'controllers' => array(
            'invokables' => array(
                'Teryt\Controller\Gus' => 'Teryt\Controller\GusController',
            ),
        ),
        
        'router' => array(
            'routes' => array(
                'gus' => array(
                    'type'    => 'segment',
                    'options' => array(
                        'route'    => '/gus/:action',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                        ),
                        'defaults' => array(
                            'controller' => 'Teryt\Controller\Gus',
                            'action'     => 'actualize',
                        ),
                    ),
                ),
            ),
        ),
        
        'view_manager' => array(
            'template_path_stack' => array(
                'teryt' => __DIR__ . '/../view',
            ),
        ),
        
        'console' => array(
            'router' => array(
                'routes' => array(
                    'gus' => array(
                        'options' => array(
                            'route'    => 'gus actualize [--verbose|-v]:verbose',
                            'defaults' => array(
                                'controller' => 'Teryt\Controller\Gus',
                                'action'     => 'actualize',
                            )
                        )
                    )
                )
            )
        )
    );
?>
