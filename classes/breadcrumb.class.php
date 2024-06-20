<?php

// this class is used to create dynamic breadcrumb menu
class Breadcrumb
{

    private static $instance = null;


    public static function getInstanceRootDirectory($currentPage, $menuLink, $menuDescription)
    {

        return self::$instance === null ? self::$instance = new Breadcrumb(currentPage: $currentPage, menuLink: $menuLink, rootDirectory: false, menuDescription: $menuDescription) : self::$instance;

    }


    public static function getInstanceSubDirectory($currentPage, $menuLink, $rootDirectory, $menuDescription)
    {

        return self::$instance === null ? self::$instance = new Breadcrumb(currentPage: $currentPage, menuLink: $menuLink, rootDirectory: false, menuDescription: $menuDescription) : self::$instance;


    }


    private bool $homeLink = true;// admin_home.php by default

    private function __construct(

        private readonly string      $currentPage,
        private readonly string      $menuLink,
        private readonly bool|null   $rootDirectory,
        private readonly string|null $menuDescription,


    )
    {

    }


    public
    function setHomeLink($link)
    {
        $this->homeLink = $link;
        return $this;

    }


    private
    function splitWords()
    {
        /*
         * replace _ with " " with title case
         * ucwords - Returns a string with the first character of each word in str capitalized, if that character is alphabetic.
         */

        return ucwords(str_replace("_", " ", $this->currentPage));
    }

    public
    function createBreadCrumb()
    { ?>
        <?php if ($this->currentPage !== 'admin_home') : // display breadcrumb menu on all pages except the homepage ?>

        <div class="container">
            <div class="pt-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= FILE_PATH['dashboard'] ?>">Home</a>
                        </li>
                        <?php if (!$this->rootDirectory) : //if the current directory is true?>
                            <li class="breadcrumb-item">
                                <a href="<?= $this->menuLink ?>"><?= $this->splitWords() ?>
                                </a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                <?= $this->menuDescription ?>
                            </li>

                        <?php else :  //otherwise remove the sub-hyperlink and display text ?>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= $this->splitWords() ?>
                            </li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
        </div>

    <?php endif; ?>

        <?php
    } // end of breadcrumb function
}