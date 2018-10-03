New-Item -Force -Path "Module" -ItemType Directory;
New-Item -Force -Path "Module/Templates" -ItemType Directory;
New-Item -Force -Path "Module/Templates/A" -ItemType Directory;
New-Item -Force -Path "Module/Templates/A/XTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\A;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class XTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\A\XTemplate;

                <?php 
            }

        }
"@;
New-Item -Force -Path "Module/Templates/A/YTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\A;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class YTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\A\YTemplate;

                <?php 
            }

        }
"@;
New-Item -Force -Path "Module/Templates/A/ZTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\A;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class ZTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\A\ZTemplate;

                <?php 
            }

        }
"@;
New-Item -Force -Path "Module/Templates/B" -ItemType Directory;
New-Item -Force -Path "Module/Templates/B/XTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\B;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class XTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\B\XTemplate;

                <?php 
            }

        }
"@;
New-Item -Force -Path "Module/Templates/B/YTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\B;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class YTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\B\YTemplate;

                <?php 
            }

        }
"@;
New-Item -Force -Path "Module/Templates/B/ZTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\B;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class ZTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\B\ZTemplate;

                <?php 
            }

        }
"@;
New-Item -Force -Path "Module/Templates/C" -ItemType Directory;
New-Item -Force -Path "Module/Templates/C/XTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\C;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class XTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\C\XTemplate;

                <?php 
            }

        }
"@;
New-Item -Force -Path "Module/Templates/C/YTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\C;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class YTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\C\YTemplate;

                <?php 
            }

        }
"@;
New-Item -Force -Path "Module/Templates/C/ZTemplate.php" -ItemType File -Value @"
<?php 

        namespace Module\Templates\C;
        
        use CrystalCode\Php\Common\Templates\TemplateBase;
        use CrystalCode\Php\Common\Templates\TemplateContextInterface;

        final class ZTemplate extends TemplateBase
        {

            /**
             *
             * @param TemplateContextInterface `$templateContext
             * @return void
             */
            protected function execute(TemplateContextInterface `$templateContext)
            {
                ?> 

                Module\Templates\C\ZTemplate;

                <?php 
            }

        }
"@;
