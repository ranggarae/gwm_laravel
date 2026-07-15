@php $user_lang = get_user_lang(); @endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{get_static_option('site_'.$user_lang.'_title')}} - {{get_static_option('site_'.$user_lang.'_tag_line')}}</title>
</head>

<body>
{{__('Redirecting.. Please Wait')}}
<form action="{{ $paytm_txn_url }}" method="post" id="payment_form">
    <?php
    foreach($paramList as $name => $value) {
        echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
    }
    ?>
    <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
</form>

<script>
    document.getElementById("payment_form").submit();
</script>
</body>

</html>
    
    
    