<?php if ( !CSite::InDir('/cars/new/') && !CSite::InDir('/cars/used/') ) { ?>
<script type='application/ld+json'>
    {
        "@context": "http://www.schema.org",
        "@type": "Organization",
        "name": "<?= $APPLICATION->ShowProperty('title');?>",
        "url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
        "image": "<?= $APPLICATION->ShowProperty('image', SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",
        "description": "<?= $APPLICATION->ShowProperty('description');?>"
    }
</script>
<?php } ?>