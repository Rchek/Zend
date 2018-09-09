<?php 
namespace Book;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'book.restful' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/book[[/isbn/:isbn][/author/:author][/title/:title][/from/:from][/to/:to][/minrating/:minrating]]',
                    'defaults' => [
                        'controller' => Controller\BookController::class,
                    ],
                ],
            ],
			'book.rpc-json' => [
                'type'    => 'Literal',
                'options' => [
                    'route' => '/rpcroute',
                    'defaults' => [
                        'controller' => Controller\BookRpcController::class,
						'action' => 'index'
                    ],
                ],
            ],
			'book.soap' => [
                'type'    => 'Literal',
                'options' => [
                    'route' => '/soap',
                    'defaults' => [
                        'controller' => Controller\BookSoapController::class,
						'action' => 'soap'
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'book' => __DIR__ . '/../view',
        ],
		 'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
];