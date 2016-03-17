<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php echo !empty($pageTitle) ? $pageTitle . " | " : "" ?> <?php echo \CBaseSystem::$pageTitle; ?></title>
        <link rel="shortcut icon" href="<?php echo $this->url->get('/images/favicon-32x32.ico'); ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo $this->url->get('/images/favicon-32x32.ico'); ?>" type="image/x-icon">
        <base href="<?php echo $this->url->get(); ?>" />
        <script>var baseUrl = "<?php echo $this->url->get(); ?>";</script>
        <?php echo $this->assets->outputCss('cssHeader'); ?>
        <?php echo $this->assets->outputJs('jsHeader'); ?> 
         
    </head>
    <body>
        
         
        
        

<div class="container-fluid">
    <div class="row">
        <div class="container">
            <div class="row">
                <?php echo $this->getContent(); ?>
            </div>
        </div>
    </div>
</div>


        
         
        
        <?php echo $this->assets->outputCss('cssFooter'); ?> 
        <?php echo $this->assets->outputJs('jsFooter'); ?>
        
          
           
        
    </body>
</html>