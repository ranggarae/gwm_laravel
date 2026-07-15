@php $user_select_lang_slug = get_default_language(); @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{get_static_option('site_'.$user_select_lang_slug.'_title'). __('Mail')}}</title>
    <style>
        .mail-container {
            max-width: 650px;
            margin: 0 auto;
            text-align: center;
        }

        .mail-container .logo-wrapper {
            background-color: #111d5c;
            padding: 20px 0 20px;
        }
        table {
            margin: 0 auto;
        }
        table {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table td, table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even){background-color: #f2f2f2;}

        table tr:hover {background-color: #ddd;}

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #111d5c;
            color: white;
        }
        footer {
            margin: 20px 0;
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="mail-container">
        <div class="logo-wrapper">
            <a href="{{url('/')}}">
                {!! render_image_markup_by_attachment_id(get_static_option('site_white_logo')) !!}
            </a>
        </div>
        <p>{{__('You Have Message From '. get_static_option('site_'.$user_select_lang_slug.'_title'))}}</p>
        <table>
            <tr>
                <td>{{get_static_option('feedback_page_form_'.$user_select_lang_slug.'_name_label')}}</td>
                <td>{{$data['feedback']->name}}</td>
            </tr>
            <tr>
                <td>{{get_static_option('feedback_page_form_'.$user_select_lang_slug.'_email_label')}}</td>
                <td>{{$data['feedback']->email}}</td>
            </tr>
            <tr>
                <td>{{get_static_option('feedback_page_form_'.$user_select_lang_slug.'_ratings_label')}}</td>
                <td>{{$data['feedback']->ratings}}</td>
            </tr>
            <tr>
                <td>{{get_static_option('feedback_page_form_'.$user_select_lang_slug.'_description_label')}}</td>
                <td>{{$data['feedback']->description}}</td>
            </tr>
            @foreach($data['field_name'] as $key => $field)
                @php $name = str_replace('-',' ',$key); @endphp
                <tr>
                    <td>{{ucwords($name)}}</td>
                    <td>{{$field}}</td>
                </tr>
            @endforeach
        </table>
        <footer>
           &copy; All Right Reserved By {{get_static_option('site_'.get_default_language().'_title')}}
        </footer>
    </div>
</body>
</html>
