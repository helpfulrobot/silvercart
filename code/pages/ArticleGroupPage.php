<?php
/**
 * Displays articles with similar attributes
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @since 20.10.2010
 * @license BSD
 * @copyright 2010 pixeltricks GmbH
 */
class ArticleGroupPage extends Page {

    public static $singular_name = "Warengruppe";
    public static $plural_name = "Warengruppen";
    public static $allowed_children = array('ArticleGroupPage');
    public static $can_be_root = false;
    public static $db = array(
    );
        public static $has_one = array(
        'groupPicture' => 'Image'
    );
    public static $has_many = array(
        'articles' => 'Article'
    );
    public static $many_many = array(
        'attributes' => 'Attribute'
    );

    /**
     * Return all fields of the backend
     *
     * @return FieldSet Fields of the CMS
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $articlesTableField = new HasManyDataObjectManager(
                        $this,
                        'articles',
                        'Article',
                        array(
                            'Title' => 'Bezeichnung',
                            'PriceAmount' => 'Preis',
                            'Weight' => 'Gewicht'
                        ),
                        'getCMSFields',
                        "`articleGroupID` = $this->ID"
        );
        $fields->addFieldToTab('Root.Content.Artikel', $articlesTableField);
        
        $attributeTableField = new ManyManyDataObjectManager(
                        $this,
                        'attributes',
                        'Attribute',
                        array(
                            'Title' => 'Bezeichnung'
                        )
        );
        $fields->addFieldToTab('Root.Content.Atribute', $attributeTableField);
        $fields->addFieldToTab("Root.Content.Gruppenbild", new FileIFrameField('groupPicture', 'Gruppenlogo'));
        
        return $fields;
    }

}

/**
 * Controller Class
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @since 18.10.2010
 * @license BSD
 * @copyright 2010 pixeltricks GmbH
 */
class ArticleGroupPage_Controller extends Page_Controller {

    protected $groupArticles;

    /**
     * execute these statements on object call
     *
     * @return void
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 18.10.2010
     */
    public function init() {


        // Get Articles for this category
        if (!isset($_GET['start']) ||
            !is_numeric($_GET['start']) ||
            (int)$_GET['start'] < 1) {
            $_GET['start'] = 0;
        }

        $SQL_start = (int)$_GET['start'];
        
        $this->groupArticles = Article::get("\"articleGroupID\" = {$this->ID}", null, null, $limit = "{$SQL_start},15");

        // Initialise formobjects

        $articleIdx = 0;
        if ($this->groupArticles) {
            foreach ($this->groupArticles as $article) {
                $this->registerCustomHtmlForm('ArticlePreviewForm'.$articleIdx, new ArticlePreviewForm($this, array('articleID' => $article->ID)));
                $articleIdx++;
            }
        }

        parent::init();

        $articleIdx = 0;
        if ($this->groupArticles) {
            foreach ($this->groupArticles as $article) {

                $article->setField('Link', $article->Link());
                $article->setField('Thumbnail', $article->image()->SetWidth(150));

                $article->articlePreviewForm = $this->InsertCustomHtmlForm(
                    'ArticlePreviewForm'.$articleIdx,
                    array(
                        $article
                    )
                );

                $articleIdx++;
            }
        }
    }

    /**
     * All articles of this group
     * 
     * @return DataObjectSet all articles of this group or FALSE
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 20.10.2010
     */
    public function getArticles() {
       return $this->groupArticles;
    }

    /**
     * Getter for an articles image.
     *
     * @return Image defined via a has_one relation in Article
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 20.10.2010
     */
    public function getArticleImage() {

        return Article::image();
    }
}