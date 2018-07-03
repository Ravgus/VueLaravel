<?php

namespace App\Http\Controllers;

use App\Events\NewEvent;
use App\Events\NewMessage;
use App\Events\PrivateMessage;
use Illuminate\Http\Request;

class StartController extends Controller
{
    //
    public function index()
    {
        $url_data = [
            [
                'title' => '123',
                'url' => 'https://www.google.com.ua'
            ],
            [
                'title' => '321',
                'url' => 'http://www.bigmir.net'
            ]
        ];

        return view('start', ['url_data' => $url_data]);
    }

    public function getJson()
    {
        return [
            array(
                'title' => '123',
                'url' => 'https://www.google.com.ua'
            ),
            array(
                'title' => '321',
                'url' => 'http://www.bigmir.net'
            )
        ];
    }

    public function chartData()
    {
        return [
            'labels' => ['март', 'апрель', 'май', 'июнь'],
            'datasets' => array(
                [
                    'label' => 'Продажи',
                    'backgroundColor' => '#F26202',
                    //'backgroundColor' => ['#F26202', '#A26202', '#B26202', '#C26202'],
                    'data' => [10000, 15000, 20000, 120000]
                ],
                [
                    'label' => 'Прошлый год',
                    'backgroundColor' => '#B56202',
                    //'backgroundColor' => ['#F26202', '#A26202', '#B26202', '#C26202'],
                    'data' => [30000, 10000, 15000, 5000]
                ]
            )
        ];
    }

    public function chartRandom()
    {
        return [
            'labels' => ['март', 'апрель', 'май', 'июнь'],
            'datasets' => array(
                [
                    'label' => 'Золото',
                    'backgroundColor' => '#F26202',
                    'data' => [rand(0, 40000), rand(0, 40000), rand(0, 40000), rand(0, 40000)]
                ],
                [
                    'label' => 'Серебро',
                    'backgroundColor' => '#B56202',
                    'data' => [rand(0, 40000), rand(0, 40000), rand(0, 40000), rand(0, 40000)]
                ]
            )
        ];
    }

    public function newEvent(Request $request)
    {
        $results = [
            'labels' => ['март', 'апрель', 'май', 'июнь'],
            'datasets' => array([
                'label' => 'Продажи',
                'backgroundColor' => '#F26202',
                'data' => [10000, 15000, 20000, 120000]
            ])
        ];

        if($request->has('label')) {
            $results['labels'][] = $request->input('label');
            $results['datasets'][0]['data'][] = (integer)$request->input('sale');

            if($request->has('realtime')) {
                if(filter_var($request->input('realtime'), FILTER_VALIDATE_BOOLEAN)) {
                    event(new NewEvent($results));
                }
            }
        }

        return $results;
    }

    public function sendMessage(Request $request)
    {
        event(new NewMessage($request->input('message')));
    }

    public function sendPrivateMessage(Request $request)
    {
        \App\Events\PrivateMessage::dispatch($request->all);
        return $request->all;
    }
}
