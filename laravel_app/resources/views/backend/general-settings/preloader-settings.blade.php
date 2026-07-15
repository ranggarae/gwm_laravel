@extends('backend.admin-master')
@section('site-title')
    {{__('Preloader Settings')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    @php $site_color = get_static_option('site_color'); @endphp
    <style>
        /* admin preloader settings */
        ul.predefine-preloader-wrap {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            flex-wrap: wrap;
        }

        ul.predefine-preloader-wrap li {
            margin: 10px;
        }

        ul.predefine-preloader-wrap li {
            display: inline-block;
            border: 1px solid #e2e2e2;
            cursor: pointer;
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        ul.predefine-preloader-wrap li.selected {
            border-color: {{$site_color}};
            position: relative;
        }
        ul.predefine-preloader-wrap li.selected:after {
            position: absolute;
            left: 0px;
            top: 0;
            z-index: 1;
            color: #fff;
            content: "\f058";
            font-size: 16px;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            line-height: 18px;
            width: 25px;
            height: 25px;
            background-color:{{$site_color}};
            padding-left: 4px;
            padding-top: 3px;

        }

        /* style 01 */

        .backend-preloader-wrap .windows8 {
            position: relative;
            width: 78px;
            height: 78px;
            margin: auto;
        }

        .backend-preloader-wrap .windows8 .wBall {
            position: absolute;
            width: 74px;
            height: 74px;
            opacity: 0;
            transform: rotate(225deg);
            -o-transform: rotate(225deg);
            -ms-transform: rotate(225deg);
            -webkit-transform: rotate(225deg);
            -moz-transform: rotate(225deg);
            animation: orbit 6.96s infinite;
            -o-animation: orbit 6.96s infinite;
            -ms-animation: orbit 6.96s infinite;
            -webkit-animation: orbit 6.96s infinite;
            -moz-animation: orbit 6.96s infinite;
        }

        .backend-preloader-wrap .windows8 .wBall .wInnerBall {
            position: absolute;
            width: 10px;
            height: 10px;
            background: {{$site_color}};
            left: 0px;
            top: 0px;
            border-radius: 10px;
        }

        .backend-preloader-wrap .windows8 #wBall_1 {
            animation-delay: 1.52s;
            -o-animation-delay: 1.52s;
            -ms-animation-delay: 1.52s;
            -webkit-animation-delay: 1.52s;
            -moz-animation-delay: 1.52s;
        }

        .backend-preloader-wrap .windows8 #wBall_2 {
            animation-delay: 0.3s;
            -o-animation-delay: 0.3s;
            -ms-animation-delay: 0.3s;
            -webkit-animation-delay: 0.3s;
            -moz-animation-delay: 0.3s;
        }

        .backend-preloader-wrap .windows8 #wBall_3 {
            animation-delay: 0.61s;
            -o-animation-delay: 0.61s;
            -ms-animation-delay: 0.61s;
            -webkit-animation-delay: 0.61s;
            -moz-animation-delay: 0.61s;
        }

        .backend-preloader-wrap .windows8 #wBall_4 {
            animation-delay: 0.91s;
            -o-animation-delay: 0.91s;
            -ms-animation-delay: 0.91s;
            -webkit-animation-delay: 0.91s;
            -moz-animation-delay: 0.91s;
        }

        .backend-preloader-wrap .windows8 #wBall_5 {
            animation-delay: 1.22s;
            -o-animation-delay: 1.22s;
            -ms-animation-delay: 1.22s;
            -webkit-animation-delay: 1.22s;
            -moz-animation-delay: 1.22s;
        }


        @keyframes orbit {
            0% {
                opacity: 1;
                z-index: 99;
                transform: rotate(180deg);
                animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                transform: rotate(300deg);
                animation-timing-function: linear;
                origin: 0%;
            }

            30% {
                opacity: 1;
                transform: rotate(410deg);
                animation-timing-function: ease-in-out;
                origin: 7%;
            }

            39% {
                opacity: 1;
                transform: rotate(645deg);
                animation-timing-function: linear;
                origin: 30%;
            }

            70% {
                opacity: 1;
                transform: rotate(770deg);
                animation-timing-function: ease-out;
                origin: 39%;
            }

            75% {
                opacity: 1;
                transform: rotate(900deg);
                animation-timing-function: ease-out;
                origin: 70%;
            }

            76% {
                opacity: 0;
                transform: rotate(900deg);
            }

            100% {
                opacity: 0;
                transform: rotate(900deg);
            }
        }

        @-o-keyframes orbit {
            0% {
                opacity: 1;
                z-index: 99;
                -o-transform: rotate(180deg);
                -o-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -o-transform: rotate(300deg);
                -o-animation-timing-function: linear;
                -o-origin: 0%;
            }

            30% {
                opacity: 1;
                -o-transform: rotate(410deg);
                -o-animation-timing-function: ease-in-out;
                -o-origin: 7%;
            }

            39% {
                opacity: 1;
                -o-transform: rotate(645deg);
                -o-animation-timing-function: linear;
                -o-origin: 30%;
            }

            70% {
                opacity: 1;
                -o-transform: rotate(770deg);
                -o-animation-timing-function: ease-out;
                -o-origin: 39%;
            }

            75% {
                opacity: 1;
                -o-transform: rotate(900deg);
                -o-animation-timing-function: ease-out;
                -o-origin: 70%;
            }

            76% {
                opacity: 0;
                -o-transform: rotate(900deg);
            }

            100% {
                opacity: 0;
                -o-transform: rotate(900deg);
            }
        }

        @-ms-keyframes orbit {
            0% {
                opacity: 1;
                z-index: 99;
                -ms-transform: rotate(180deg);
                -ms-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -ms-transform: rotate(300deg);
                -ms-animation-timing-function: linear;
                -ms-origin: 0%;
            }

            30% {
                opacity: 1;
                -ms-transform: rotate(410deg);
                -ms-animation-timing-function: ease-in-out;
                -ms-origin: 7%;
            }

            39% {
                opacity: 1;
                -ms-transform: rotate(645deg);
                -ms-animation-timing-function: linear;
                -ms-origin: 30%;
            }

            70% {
                opacity: 1;
                -ms-transform: rotate(770deg);
                -ms-animation-timing-function: ease-out;
                -ms-origin: 39%;
            }

            75% {
                opacity: 1;
                -ms-transform: rotate(900deg);
                -ms-animation-timing-function: ease-out;
                -ms-origin: 70%;
            }

            76% {
                opacity: 0;
                -ms-transform: rotate(900deg);
            }

            100% {
                opacity: 0;
                -ms-transform: rotate(900deg);
            }
        }

        @-webkit-keyframes orbit {
            0% {
                opacity: 1;
                z-index: 99;
                -webkit-transform: rotate(180deg);
                -webkit-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -webkit-transform: rotate(300deg);
                -webkit-animation-timing-function: linear;
                -webkit-origin: 0%;
            }

            30% {
                opacity: 1;
                -webkit-transform: rotate(410deg);
                -webkit-animation-timing-function: ease-in-out;
                -webkit-origin: 7%;
            }

            39% {
                opacity: 1;
                -webkit-transform: rotate(645deg);
                -webkit-animation-timing-function: linear;
                -webkit-origin: 30%;
            }

            70% {
                opacity: 1;
                -webkit-transform: rotate(770deg);
                -webkit-animation-timing-function: ease-out;
                -webkit-origin: 39%;
            }

            75% {
                opacity: 1;
                -webkit-transform: rotate(900deg);
                -webkit-animation-timing-function: ease-out;
                -webkit-origin: 70%;
            }

            76% {
                opacity: 0;
                -webkit-transform: rotate(900deg);
            }

            100% {
                opacity: 0;
                -webkit-transform: rotate(900deg);
            }
        }

        @-moz-keyframes orbit {
            0% {
                opacity: 1;
                z-index: 99;
                -moz-transform: rotate(180deg);
                -moz-animation-timing-function: ease-out;
            }

            7% {
                opacity: 1;
                -moz-transform: rotate(300deg);
                -moz-animation-timing-function: linear;
                -moz-origin: 0%;
            }

            30% {
                opacity: 1;
                -moz-transform: rotate(410deg);
                -moz-animation-timing-function: ease-in-out;
                -moz-origin: 7%;
            }

            39% {
                opacity: 1;
                -moz-transform: rotate(645deg);
                -moz-animation-timing-function: linear;
                -moz-origin: 30%;
            }

            70% {
                opacity: 1;
                -moz-transform: rotate(770deg);
                -moz-animation-timing-function: ease-out;
                -moz-origin: 39%;
            }

            75% {
                opacity: 1;
                -moz-transform: rotate(900deg);
                -moz-animation-timing-function: ease-out;
                -moz-origin: 70%;
            }

            76% {
                opacity: 0;
                -moz-transform: rotate(900deg);
            }

            100% {
                opacity: 0;
                -moz-transform: rotate(900deg);
            }
        }

        /* style 02 */
        .backend-preloader-wrap {
        }

        .backend-preloader-wrap .cssload-thecube {
            width: 50px;
            height: 50px;
            margin: 0 auto;
            position: relative;
            transform: rotateZ(45deg);
            -o-transform: rotateZ(45deg);
            -ms-transform: rotateZ(45deg);
            -webkit-transform: rotateZ(45deg);
            -moz-transform: rotateZ(45deg);
        }

        .backend-preloader-wrap .cssload-thecube .cssload-cube {
            position: relative;
            transform: rotateZ(45deg);
            -o-transform: rotateZ(45deg);
            -ms-transform: rotateZ(45deg);
            -webkit-transform: rotateZ(45deg);
            -moz-transform: rotateZ(45deg);
        }

        .backend-preloader-wrap .cssload-thecube .cssload-cube {
            float: left;
            width: 50%;
            height: 50%;
            position: relative;
            transform: scale(1.1);
            -o-transform: scale(1.1);
            -ms-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
        }

        .backend-preloader-wrap .cssload-thecube .cssload-cube:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: {{$site_color}};
            animation: cssload-fold-thecube 2.76s infinite linear both;
            -o-animation: cssload-fold-thecube 2.76s infinite linear both;
            -ms-animation: cssload-fold-thecube 2.76s infinite linear both;
            -webkit-animation: cssload-fold-thecube 2.76s infinite linear both;
            -moz-animation: cssload-fold-thecube 2.76s infinite linear both;
            transform-origin: 100% 100%;
            -o-transform-origin: 100% 100%;
            -ms-transform-origin: 100% 100%;
            -webkit-transform-origin: 100% 100%;
            -moz-transform-origin: 100% 100%;
        }

        .backend-preloader-wrap .cssload-thecube .cssload-c2 {
            transform: scale(1.1) rotateZ(90deg);
            -o-transform: scale(1.1) rotateZ(90deg);
            -ms-transform: scale(1.1) rotateZ(90deg);
            -webkit-transform: scale(1.1) rotateZ(90deg);
            -moz-transform: scale(1.1) rotateZ(90deg);
        }

        .backend-preloader-wrap .cssload-thecube .cssload-c3 {
            transform: scale(1.1) rotateZ(180deg);
            -o-transform: scale(1.1) rotateZ(180deg);
            -ms-transform: scale(1.1) rotateZ(180deg);
            -webkit-transform: scale(1.1) rotateZ(180deg);
            -moz-transform: scale(1.1) rotateZ(180deg);
        }

        .backend-preloader-wrap .cssload-thecube .cssload-c4 {
            transform: scale(1.1) rotateZ(270deg);
            -o-transform: scale(1.1) rotateZ(270deg);
            -ms-transform: scale(1.1) rotateZ(270deg);
            -webkit-transform: scale(1.1) rotateZ(270deg);
            -moz-transform: scale(1.1) rotateZ(270deg);
        }

        .backend-preloader-wrap .cssload-thecube .cssload-c2:before {
            animation-delay: 0.35s;
            -o-animation-delay: 0.35s;
            -ms-animation-delay: 0.35s;
            -webkit-animation-delay: 0.35s;
            -moz-animation-delay: 0.35s;
        }

        .backend-preloader-wrap .cssload-thecube .cssload-c3:before {
            animation-delay: 0.69s;
            -o-animation-delay: 0.69s;
            -ms-animation-delay: 0.69s;
            -webkit-animation-delay: 0.69s;
            -moz-animation-delay: 0.69s;
        }

        .backend-preloader-wrap .cssload-thecube .cssload-c4:before {
            animation-delay: 1.04s;
            -o-animation-delay: 1.04s;
            -ms-animation-delay: 1.04s;
            -webkit-animation-delay: 1.04s;
            -moz-animation-delay: 1.04s;
        }


        @keyframes cssload-fold-thecube {
            0%, 10% {
                transform: perspective(136px) rotateX(-180deg);
                opacity: 0;
            }
            25%,
            75% {
                transform: perspective(136px) rotateX(0deg);
                opacity: 1;
            }
            90%,
            100% {
                transform: perspective(136px) rotateY(180deg);
                opacity: 0;
            }
        }

        @-o-keyframes cssload-fold-thecube {
            0%, 10% {
                -o-transform: perspective(136px) rotateX(-180deg);
                opacity: 0;
            }
            25%,
            75% {
                -o-transform: perspective(136px) rotateX(0deg);
                opacity: 1;
            }
            90%,
            100% {
                -o-transform: perspective(136px) rotateY(180deg);
                opacity: 0;
            }
        }

        @-ms-keyframes cssload-fold-thecube {
            0%, 10% {
                -ms-transform: perspective(136px) rotateX(-180deg);
                opacity: 0;
            }
            25%,
            75% {
                -ms-transform: perspective(136px) rotateX(0deg);
                opacity: 1;
            }
            90%,
            100% {
                -ms-transform: perspective(136px) rotateY(180deg);
                opacity: 0;
            }
        }

        @-webkit-keyframes cssload-fold-thecube {
            0%, 10% {
                -webkit-transform: perspective(136px) rotateX(-180deg);
                opacity: 0;
            }
            25%,
            75% {
                -webkit-transform: perspective(136px) rotateX(0deg);
                opacity: 1;
            }
            90%,
            100% {
                -webkit-transform: perspective(136px) rotateY(180deg);
                opacity: 0;
            }
        }

        @-moz-keyframes cssload-fold-thecube {
            0%, 10% {
                -moz-transform: perspective(136px) rotateX(-180deg);
                opacity: 0;
            }
            25%,
            75% {
                -moz-transform: perspective(136px) rotateX(0deg);
                opacity: 1;
            }
            90%,
            100% {
                -moz-transform: perspective(136px) rotateY(180deg);
                opacity: 0;
            }
        }

        /* style 03 */
        .backend-preloader-wrap{}
        .backend-preloader-wrap .bubblingG {
            text-align: center;
            width:78px;
            height:49px;
            margin: auto;
        }

        .backend-preloader-wrap .bubblingG span {
            display: inline-block;
            vertical-align: middle;
            width: 10px;
            height: 10px;
            margin: 24px auto;
            background: {{$site_color}};
            border-radius: 49px;
            -o-border-radius: 49px;
            -ms-border-radius: 49px;
            -webkit-border-radius: 49px;
            -moz-border-radius: 49px;
            animation: bubblingG 1.5s infinite alternate;
            -o-animation: bubblingG 1.5s infinite alternate;
            -ms-animation: bubblingG 1.5s infinite alternate;
            -webkit-animation: bubblingG 1.5s infinite alternate;
            -moz-animation: bubblingG 1.5s infinite alternate;
        }

        .backend-preloader-wrap #bubblingG_1 {
            animation-delay: 0s;
            -o-animation-delay: 0s;
            -ms-animation-delay: 0s;
            -webkit-animation-delay: 0s;
            -moz-animation-delay: 0s;
        }

        .backend-preloader-wrap #bubblingG_2 {
            animation-delay: 0.45s;
            -o-animation-delay: 0.45s;
            -ms-animation-delay: 0.45s;
            -webkit-animation-delay: 0.45s;
            -moz-animation-delay: 0.45s;
        }

        .backend-preloader-wrap #bubblingG_3 {
            animation-delay: 0.9s;
            -o-animation-delay: 0.9s;
            -ms-animation-delay: 0.9s;
            -webkit-animation-delay: 0.9s;
            -moz-animation-delay: 0.9s;
        }



        @keyframes bubblingG {
            0% {
                width: 10px;
                height: 10px;
                background-color:{{$site_color}};
                transform: translateY(0);
            }

            100% {
                width: 23px;
                height: 23px;
                background-color:{{$site_color}};
                transform: translateY(-20px);
            }
        }

        @-o-keyframes bubblingG {
            0% {
                width: 10px;
                height: 10px;
                background-color:{{$site_color}};
                -o-transform: translateY(0);
            }

            100% {
                width: 23px;
                height: 23px;
                background-color:{{$site_color}};
                -o-transform: translateY(-20px);
            }
        }

        @-ms-keyframes bubblingG {
            0% {
                width: 10px;
                height: 10px;
                background-color:{{$site_color}};
                -ms-transform: translateY(0);
            }

            100% {
                width: 23px;
                height: 23px;
                background-color:{{$site_color}};
                -ms-transform: translateY(-20px);
            }
        }

        @-webkit-keyframes bubblingG {
            0% {
                width: 10px;
                height: 10px;
                background-color: {{$site_color}};
                -webkit-transform: translateY(0);
            }

            100% {
                width: 23px;
                height: 23px;
                background-color: {{$site_color}};
                -webkit-transform: translateY(-20px);
            }
        }

        @-moz-keyframes bubblingG {
            0% {
                width: 10px;
                height: 10px;
                background-color: {{$site_color}};
                -moz-transform: translateY(0);
            }

            100% {
                width: 23px;
                height: 23px;
                background-color: {{$site_color}};
                -moz-transform: translateY(-20px);
            }
        }
        /* style 04 */
        .backend-preloader-wrap{}

        .backend-preloader-wrap .cssload-loader {
            display: block;
            margin:0 auto;
            width: 29px;
            height: 29px;
            position: relative;
            border: 4px solid {{$site_color}};
            animation: cssload-loader 2.3s infinite ease;
            -o-animation: cssload-loader 2.3s infinite ease;
            -ms-animation: cssload-loader 2.3s infinite ease;
            -webkit-animation: cssload-loader 2.3s infinite ease;
            -moz-animation: cssload-loader 2.3s infinite ease;
        }

        .backend-preloader-wrap .cssload-loader-inner {
            vertical-align: top;
            display: inline-block;
            width: 100%;
            background-color: {{$site_color}};
            animation: cssload-loader-inner 2.3s infinite ease-in;
            -o-animation: cssload-loader-inner 2.3s infinite ease-in;
            -ms-animation: cssload-loader-inner 2.3s infinite ease-in;
            -webkit-animation: cssload-loader-inner 2.3s infinite ease-in;
            -moz-animation: cssload-loader-inner 2.3s infinite ease-in;
        }

        @keyframes cssload-loader {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(180deg);
            }

            50% {
                transform: rotate(180deg);
            }

            75% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @-o-keyframes cssload-loader {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(180deg);
            }

            50% {
                transform: rotate(180deg);
            }

            75% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @-ms-keyframes cssload-loader {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(180deg);
            }

            50% {
                transform: rotate(180deg);
            }

            75% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @-webkit-keyframes cssload-loader {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(180deg);
            }

            50% {
                transform: rotate(180deg);
            }

            75% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes cssload-loader {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(180deg);
            }

            50% {
                transform: rotate(180deg);
            }

            75% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes cssload-loader-inner {
            0% {
                height: 0%;
            }

            25% {
                height: 0%;
            }

            50% {
                height: 100%;
            }

            75% {
                height: 100%;
            }

            100% {
                height: 0%;
            }
        }

        @-o-keyframes cssload-loader-inner {
            0% {
                height: 0%;
            }

            25% {
                height: 0%;
            }

            50% {
                height: 100%;
            }

            75% {
                height: 100%;
            }

            100% {
                height: 0%;
            }
        }

        @-ms-keyframes cssload-loader-inner {
            0% {
                height: 0%;
            }

            25% {
                height: 0%;
            }

            50% {
                height: 100%;
            }

            75% {
                height: 100%;
            }

            100% {
                height: 0%;
            }
        }

        @-webkit-keyframes cssload-loader-inner {
            0% {
                height: 0%;
            }

            25% {
                height: 0%;
            }

            50% {
                height: 100%;
            }

            75% {
                height: 100%;
            }

            100% {
                height: 0%;
            }
        }

        @-moz-keyframes cssload-loader-inner {
            0% {
                height: 0%;
            }

            25% {
                height: 0%;
            }

            50% {
                height: 100%;
            }

            75% {
                height: 100%;
            }

            100% {
                height: 0%;
            }
        }
        /* style 05*/
        .backend-preloader-wrap .cssload-container {
            position: relative;
            width: 97px;
            height: 224px;
            overflow: hidden;
            margin:0px auto;
        }

        .backend-preloader-wrap .cssload-container .cssload-item {
            margin: auto;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 49px;
            height: 49px;
            background-color: {{$site_color}};
            box-sizing: border-box;
            -o-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-shadow: 0 0 8px 1px rgba(0,0,0,0.25);
            -o-box-shadow: 0 0 8px 1px rgba(0,0,0,0.25);
            -ms-box-shadow: 0 0 8px 1px rgba(0,0,0,0.25);
            -webkit-box-shadow: 0 0 8px 1px rgba(0,0,0,0.25);
            -moz-box-shadow: 0 0 8px 1px rgba(0,0,0,0.25);
        }

        .backend-preloader-wrap .cssload-container .cssload-moon {
            border-bottom: 10px solid rgb(102,102,102);
            border-radius: 50%;
            -o-border-radius: 50%;
            -ms-border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            animation: spin 1.15s ease infinite;
            -o-animation: spin 1.15s ease infinite;
            -ms-animation: spin 1.15s ease infinite;
            -webkit-animation: spin 1.15s ease infinite;
            -moz-animation: spin 1.15s ease infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spin {
            from {
                -o-transform: rotate(0deg);
            }
            to {
                -o-transform: rotate(360deg);
            }
        }

        @-ms-keyframes spin {
            from {
                -ms-transform: rotate(0deg);
            }
            to {
                -ms-transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            from {
                -webkit-transform: rotate(0deg);
            }
            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @-moz-keyframes spin {
            from {
                -moz-transform: rotate(0deg);
            }
            to {
                -moz-transform: rotate(360deg);
            }
        }

        /*  style 06 */
        .backend-preloader-wrap .cssload-container-new {
            width: 100%;
            height: 49px;
            text-align: center;
        }

        .backend-preloader-wrap .cssload-speeding-wheel {
            width: 49px;
            height: 49px;
            margin: 0 auto;
            border: 3px solid {{$site_color}};
            border-radius: 50%;
            border-left-color: transparent;
            border-right-color: transparent;
            animation: cssload-spin 575ms infinite linear;
            -o-animation: cssload-spin 575ms infinite linear;
            -ms-animation: cssload-spin 575ms infinite linear;
            -webkit-animation: cssload-spin 575ms infinite linear;
            -moz-animation: cssload-spin 575ms infinite linear;
        }

        @keyframes cssload-spin {
            100%{ transform: rotate(360deg); transform: rotate(360deg); }
        }

        @-o-keyframes cssload-spin {
            100%{ -o-transform: rotate(360deg); transform: rotate(360deg); }
        }

        @-ms-keyframes cssload-spin {
            100%{ -ms-transform: rotate(360deg); transform: rotate(360deg); }
        }

        @-webkit-keyframes cssload-spin {
            100%{ -webkit-transform: rotate(360deg); transform: rotate(360deg); }
        }

        @-moz-keyframes cssload-spin {
            100%{ -moz-transform: rotate(360deg); transform: rotate(360deg); }
        }
        /* style 07 */
        .backend-preloader-wrap .wrapper {
            margin: auto;
            display: block;
        }

        .backend-preloader-wrap .cssload-loader {
            width: 49px;
            height: 49px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            background: {{$site_color}};
        }
        .backend-preloader-wrap .cssload-loader,
        .backend-preloader-wrap .cssload-loader:before,
        .backend-preloader-wrap .cssload-loader:after {
            animation: 1.15s infinite ease-in-out;
            -o-animation: 1.15s infinite ease-in-out;
            -ms-animation: 1.15s infinite ease-in-out;
            -webkit-animation: 1.15s infinite ease-in-out;
            -moz-animation: 1.15s infinite ease-in-out;
        }
        .backend-preloader-wrap .cssload-loader:before,
        .backend-preloader-wrap .cssload-loader:after {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .backend-preloader-wrap .cssload-loader {
            animation-name: cssload-loader;
            -o-animation-name: cssload-loader;
            -ms-animation-name: cssload-loader;
            -webkit-animation-name: cssload-loader;
            -moz-animation-name: cssload-loader; }


        @keyframes cssload-loader {
            from { transform: scale(0); opacity: 1; }
            to	 { transform: scale(1); opacity: 0; }
        }

        @-o-keyframes cssload-loader {
            from { -o-transform: scale(0); opacity: 1; }
            to	 { -o-transform: scale(1); opacity: 0; }
        }

        @-ms-keyframes cssload-loader {
            from { -ms-transform: scale(0); opacity: 1; }
            to	 { -ms-transform: scale(1); opacity: 0; }
        }

        @-webkit-keyframes cssload-loader {
            from { -webkit-transform: scale(0); opacity: 1; }
            to	 { -webkit-transform: scale(1); opacity: 0; }
        }

        @-moz-keyframes cssload-loader {
            from { -moz-transform: scale(0); opacity: 1; }
            to	 { -moz-transform: scale(1); opacity: 0; }
        }

        /* style 08 */
        .backend-preloader-wrap .wrapper-08 {
            margin: auto;
            display: block;
        }

        .backend-preloader-wrap .wrapper-08 .cssload-loader {
            width: 49px;
            height: 49px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            vertical-align: middle;
        }

        .backend-preloader-wrap .wrapper-08 .cssload-loader {
            width: 49px;
            height: 49px;
            border-radius: 50%;
            margin: 3em;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            background-color: {{$site_color}};
        }
        .backend-preloader-wrap .wrapper-08 .cssload-loader,
        .backend-preloader-wrap .wrapper-08 .cssload-loader:before,
        .backend-preloader-wrap .wrapper-08 .cssload-loader:after {
            animation: 1.15s infinite ease-in-out;
            -o-animation: 1.15s infinite ease-in-out;
            -ms-animation: 1.15s infinite ease-in-out;
            -webkit-animation: 1.15s infinite ease-in-out;
            -moz-animation: 1.15s infinite ease-in-out;
        }
        .backend-preloader-wrap .wrapper-08 .cssload-loader:before,
        .backend-preloader-wrap .wrapper-08 .cssload-loader:after {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .backend-preloader-wrap .wrapper-08 .cssload-loader:before,
        .backend-preloader-wrap .wrapper-08 .cssload-loader:after {
            content: "";
        }

        .backend-preloader-wrap .wrapper-08 .cssload-loader {
            animation: cssload-animation 1.15s infinite linear;
            -o-animation: cssload-animation 1.15s infinite linear;
            -ms-animation: cssload-animation 1.15s infinite linear;
            -webkit-animation: cssload-animation 1.15s infinite linear;
            -moz-animation: cssload-animation 1.15s infinite linear;
        }



        @keyframes cssload-animation {
            0% {	 transform: rotate(0deg); border-radius: 50%; }
            50% {	transform: rotate(90deg); border-radius: 0%; }
            100% { transform: rotate(180deg); border-radius: 50%; }
        }

        @-o-keyframes cssload-animation {
            0% {	 -o-transform: rotate(0deg); border-radius: 50%; }
            50% {	-o-transform: rotate(90deg); border-radius: 0%; }
            100% { -o-transform: rotate(180deg); border-radius: 50%; }
        }

        @-ms-keyframes cssload-animation {
            0% {	 -ms-transform: rotate(0deg); border-radius: 50%; }
            50% {	-ms-transform: rotate(90deg); border-radius: 0%; }
            100% { -ms-transform: rotate(180deg); border-radius: 50%; }
        }

        @-webkit-keyframes cssload-animation {
            0% {	 -webkit-transform: rotate(0deg); border-radius: 50%; }
            50% {	-webkit-transform: rotate(90deg); border-radius: 0%; }
            100% { -webkit-transform: rotate(180deg); border-radius: 50%; }
        }

        @-moz-keyframes cssload-animation {
            0% {	 -moz-transform: rotate(0deg); border-radius: 50%; }
            50% {	-moz-transform: rotate(90deg); border-radius: 0%; }
            100% { -moz-transform: rotate(180deg); border-radius: 50%; }
        }

    </style>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Preloader Settings")}}</h4>
                        <form action="{{route('admin.general.preloader.settings')}}" method="Post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="preloader_default" id="preloader_default"
                                   value="{{get_static_option('preloader_default')}}">
                            <div class="form-group">
                                <label for="preloader_status"><strong>{{__('Preloader Enable/Disable')}}</strong></label>
                                <label class="switch">
                                    <input type="checkbox" name="preloader_status"
                                           @if(!empty(get_static_option('preloader_status'))) checked
                                           @endif id="preloader_status">
                                    <span class="slider onff"></span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="preloader_custom"><strong>{{__('Custom Image Preloader Enable/Disable')}}</strong></label>
                                <label class="switch">
                                    <input type="checkbox" name="preloader_custom"
                                           @if(!empty(get_static_option('preloader_custom'))) checked
                                           @endif id="preloader_custom">
                                    <span class="slider onff"></span>
                                </label>
                            </div>
                            <div class="form-group custom_preloader_field_wrapper"
                                 style="display: @if(!empty(get_static_option('preloader_custom'))) block @else none @endif">
                                <label for="preloader_custom_image"><strong>{{__('Custom Preloader Image')}}</strong></label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap">
                                        @php
                                            $blog_img = get_attachment_image_by_id(get_static_option('preloader_custom_image'),null,true);
                                            $blog_image_btn_label = 'Upload Image';
                                        @endphp
                                        @if (!empty($blog_img))
                                            <div class="attachment-preview">
                                                <div class="thumbnail">
                                                    <div class="centered">
                                                        <img class="avatar user-thumb" src="{{$blog_img['img_url']}}"
                                                             alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            @php  $blog_image_btn_label = 'Change Image'; @endphp
                                        @endif
                                    </div>
                                    <input type="hidden" id="preloader_custom_image" name="preloader_custom_image"
                                           value="{{get_static_option('preloader_custom_image')}}">
                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                            data-btntitle="Select Image" data-modaltitle="Upload Image"
                                            data-toggle="modal" data-target="#media_upload_modal">
                                        {{__($blog_image_btn_label)}}
                                    </button>
                                </div>
                                <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png,gif.')}}</small>
                            </div>
                            <ul class="predefine-preloader-wrap"
                                style="display: @if(!empty(get_static_option('preloader_custom'))) none @else flex @endif">
                                <li data-preloader="1">
                                    <div class="backend-preloader-wrap">
                                        <div class="backend-preloader-inner">
                                            <div class="windows8">
                                                <div class="wBall" id="wBall_1">
                                                    <div class="wInnerBall"></div>
                                                </div>
                                                <div class="wBall" id="wBall_2">
                                                    <div class="wInnerBall"></div>
                                                </div>
                                                <div class="wBall" id="wBall_3">
                                                    <div class="wInnerBall"></div>
                                                </div>
                                                <div class="wBall" id="wBall_4">
                                                    <div class="wInnerBall"></div>
                                                </div>
                                                <div class="wBall" id="wBall_5">
                                                    <div class="wInnerBall"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li data-preloader="2">
                                    <div class="backend-preloader-wrap">
                                        <div class="backend-preloader-inner">
                                            <div class="cssload-thecube">
                                                <div class="cssload-cube cssload-c1"></div>
                                                <div class="cssload-cube cssload-c2"></div>
                                                <div class="cssload-cube cssload-c4"></div>
                                                <div class="cssload-cube cssload-c3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li data-preloader="3">
                                    <div class="backend-preloader-wrap">
                                        <div class="backend-preloader-inner">
                                            <div class="bubblingG">
                                                <span id="bubblingG_1"></span>
                                                <span id="bubblingG_2"></span>
                                                <span id="bubblingG_3"></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li data-preloader="4">
                                    <div class="backend-preloader-wrap">
                                        <div class="backend-preloader-inner">
                                            <span class="cssload-loader"><span class="cssload-loader-inner"></span></span>
                                        </div>
                                    </div>
                                </li>
                                <li data-preloader="5">
                                    <div class="backend-preloader-wrap">
                                        <div class="backend-preloader-inner">
                                            <div class="cssload-container ">
                                                <div class="cssload-item cssload-moon"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li data-preloader="6">
                                    <div class="backend-preloader-wrap">
                                        <div class="backend-preloader-inner">
                                            <div class="cssload-container-new">
                                                <div class="cssload-speeding-wheel"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li data-preloader="7">
                                    <div class="backend-preloader-wrap">
                                        <div class="backend-preloader-inner">
                                            <div class="wrapper">
                                                <div class="cssload-loader"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li data-preloader="8">
                                    <div class="backend-preloader-wrap">
                                        <div class="backend-preloader-inner">
                                            <div class="wrapper-08">
                                                <div class="cssload-loader"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40"
                                    id="db_backup_btn">{{__('Save Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                selectDefaultPreloader()

                function selectDefaultPreloader() {
                    var value = $('#preloader_default').val();
                    $('.predefine-preloader-wrap > li[data-preloader="' + value + '"]').addClass('selected');
                }

                $(document).on('click', '.predefine-preloader-wrap > li', function (e) {
                    e.preventDefault();
                    var el = $(this);
                    el.addClass('selected').siblings().removeClass('selected');
                    $('#preloader_default').val(el.data('preloader'));
                });

                $(document).on('change', '#preloader_custom', function (e) {
                    e.preventDefault();
                    var el = $(this);
                    var preloaderField = $('.custom_preloader_field_wrapper');
                    var preDefinePreloader = $('.predefine-preloader-wrap');
                    if (el.is(':checked')) {
                        preloaderField.show();
                        preDefinePreloader.hide();
                    } else {
                        preloaderField.hide();
                        preDefinePreloader.css({
                            'display': 'flex'
                        });
                    }
                })

            });
        }(jQuery));
    </script>
@endsection
