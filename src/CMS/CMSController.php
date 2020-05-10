<?php

namespace Lii\CMS;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CMSController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";


    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $db = $this->app->db;
        $db->connect();

        // Use $this->app to access the framework services.
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $page = $this->app->page;
        $title = "CMS Admin | oophp";

        $page->add("cms/index");

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/content
     *
     * @return object
     */
    public function contentAction() : object
    {
        $page = $this->app->page;
        $title = "CMS content | oophp";

        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);

        $page->add("cms/menu");
        $page->add("cms/content", [
            "resultset" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/admin
     *
     * @return object
     */
    public function adminAction() : object
    {
        $page = $this->app->page;
        $title = "CMS content | oophp";

        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);

        $page->add("cms/menu");
        $page->add("cms/admin", [
            "resultset" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/pages
     *
     * @return object
     */
    public function pagesAction() : object
    {
        $page = $this->app->page;
        $title = "CMS content | oophp";

        $sql = "SELECT * FROM content WHERE type = 'page';";
        $res = $this->app->db->executeFetchAll($sql);

        $page->add("cms/menu");
        $page->add("cms/pages", [
            "resultset" => $res,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/blogs
     *
     * @return object
     */
    public function blogsAction() : object
    {
        $page = $this->app->page;
        $title = "CMS content | oophp";

        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;
        $resultset = $this->app->db->executeFetchAll($sql, ["post"]);
        $page->add("cms/menu");
        $page->add("cms/blogs", [
            "resultset" => $resultset,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/blog<value>
     *
     * @return object
     */
    public function blogAction($url) : object
    {
        $page = $this->app->page;
        $title = "CMS content | oophp";

        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
    slug = ?
    OR path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        $content = $this->app->db->executeFetch($sql, [$url, $url, "post"]);
        $page->add("cms/blogpost", [
            "content" => $content,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/page<value>
     *
     * @return object
     */
    public function pageAction($url) : object
    {
        $page = $this->app->page;
        $title = "CMS content | oophp";

        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    OR slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $content = $this->app->db->executeFetch($sql, [$url, $url, "page"]);
        if (!$content) {
            return $this->app->response->redirect("cms/notfound");
        }

        $page->add("cms/page", [
            "content" => $content,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/notfound
     *
     * @return object
     */
    public function notfoundAction() : object
    {
        $page = $this->app->page;
        $title = "404 page not found";

        $page->add("cms/404");

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * GET METHOD mountpoint/edit
     *
     * @return object
     */
    public function editActionGet() : object
    {
        $title = "CMS Admin | oophp";
        $error = "";
        $page = $this->app->page;
        $request = $this->app->request;
        $db = $this->app->db;

        $id = esc($request->getGet("id"));

        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $db->executeFetch($sql, [$id]);

        $data = [
            "content" => $content,
            "error" => $error,
        ];

        $page->add("cms/menu");
        $page->add("cms/edit", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * POST METHOD mountpoint/edit
     *
     * @return object
     */
    public function editActionPost() : object
    {
        $title = "CMS Admin | oophp";
        $slugError = "";
        $page = $this->app->page;
        $request = $this->app->request;
        $db = $this->app->db;

        $contentId = $request->getPost("contentId");
        $contentTitle = $request->getPost("contentTitle");
        $contentPath = $request->getPost("contentPath");
        $contentSlug = $request->getPost("contentSlug");
        $contentData = $request->getPost("contentData");
        $contentType = $request->getPost("contentType");
        $contentFilter = $request->getPost("contentFilter");
        $contentPublish = $request->getPost("contentPublish");

        if (!$contentSlug) {
            $contentSlug = slugify($contentTitle);
        }
        if (!$contentPath) {
            $contentPath = null;
        }

        // Check if slug is a duplicate
        $slugSql = "SELECT id FROM content WHERE slug = ?;";
        $slugRes = $db->executeFetch($slugSql, [$contentSlug]);
        if ($slugRes != null and $slugRes->id != $contentId) {
            $slugError = "Slug already exists. Content saved without a slug!";
            $contentSlug = null;
        }
//         $slugError = $slugRes;

        $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $db->execute($sql, [$contentTitle, $contentPath, $contentSlug, $contentData, $contentType, $contentFilter, $contentPublish, $contentId]);

        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $db->executeFetch($sql, [$contentId]);

        $data = [
            "content" => $content,
            "error" => $slugError,
        ];

        $page->add("cms/menu");
        $page->add("cms/edit", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * GET METHOD mountpoint/create
     *
     * @return object
     */
    public function createActionGet() : object
    {
        $title = "CMS create | oophp";
        $page = $this->app->page;

        $page->add("cms/menu");
        $page->add("cms/create");

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * POST METHOD mountpoint/create
     *
     * @return object
     */
    public function createActionPost() : object
    {
        $title = $this->app->request->getPost("contentTitle");

        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->app->db->execute($sql, [$title]);
        $id = $this->app->db->lastInsertId();

        return $this->app->response->redirect("cms/edit?id=$id");
    }

    /**
     * This is the movies method action, it handles:
     * GET METHOD mountpoint/delete
     *
     * @return object
     */
    public function deleteActionGet() : object
    {
        $title = "CMS admin | oophp";
        $page = $this->app->page;
        $request = $this->app->request;
        $db = $this->app->db;

        $id = esc($request->getGet("id"));

        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $db->executeFetch($sql, [$id]);

        $data = [
            "content" => $content,
        ];

        $page->add("cms/menu");
        $page->add("cms/delete", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * POST METHOD mountpoint/delete
     *
     * @return object
     */
    public function deleteActionPost() : object
    {
        $db = $this->app->db;

        $contentId = $this->app->request->getPost("contentId");

//         $sql = "DELETE FROM content WHERE id = ?;";
        $sql = "UPDATE content SET deleted = now() WHERE id = ?;";

        $db->execute($sql, [$contentId]);
        return $this->app->response->redirect("cms/admin");
    }

    /**
     * This is the debug method action, it handles:
     * GET METHOD mountpoint/reset
     *
     * @return object
     */
    public function resetActionGet() : object
    {
        $page = $this->app->page;
        $title = "CMS admin | oophp";

        $page->add("cms/menu");
        $page->add("cms/reset");

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the debug method action, it handles:
     * POST METHOD mountpoint/reset
     *
     * @return object
     */
    public function resetActionPost() : object
    {
        if ($this->app->request->getPost("reset")) {
//             $db = $this->app->db;
//             $db->connect();

            $sql = "DELETE FROM content;";
            $this->app->db->execute($sql);

            $sql = "INSERT INTO `content` (`path`, `slug`, `type`, `title`, `data`, `filter`) VALUES
                ('hem', null, 'page', 'Hem', 'Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter nl2br som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.', 'bbcode,nl2br'),
                ('om', null, 'page', 'Om', 'Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.', 'markdown'),
                ('blogpost-1', 'valkommen-till-min-blogg', 'post', 'Välkommen till min blogg!', 'Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.', 'link,nl2br'),
                ('blogpost-2', 'nu-har-sommaren-kommit', 'post', 'Nu har sommaren kommit', 'Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.', 'nl2br'),
                ('blogpost-3', 'nu-har-hosten-kommit', 'post', 'Nu har hösten kommit', 'Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost', 'nl2br');";

            $this->app->db->execute($sql);
        }

        return $this->app->response->redirect("cms/content");
    }
}
