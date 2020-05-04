<?php

namespace Lii\Movie;

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
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
//     private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
//     public function initialize() : void
//     {
//         // Use to initialise member variables.
//         $this->db = "active";
//         $this->turn = "computer";
//
//         // Use $this->app to access the framework services.
//     }


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
        $title = "Movie database | oophp";

        $this->app->page->add("movie/index");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the debug method action, it handles:
     * ANY METHOD mountpoint/debug
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}";
        return "Debug my Movie!";
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/movies
     *
     * @return object
     */
    public function moviesAction() : object
    {
        $title = "Movie database | oophp";

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/menu");
        $this->app->page->add("movie/movies", [
            "resultset" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/searchtitle
     *
     * @return object
     */
    public function searchTitleActionGet() : object
    {
        $title = "Movie database | oophp";

        $this->app->db->connect();
        $searchTitle = $this->app->request->getGet("searchTitle", "");
        $resultset = null;

        if ($searchTitle != "") {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$searchTitle]);
        }

        $data = [
            "searchTitle" => $searchTitle,
            "resultset" => $resultset,
        ];

        $this->app->page->add("movie/menu");
        $this->app->page->add("movie/search-title", $data);
        $this->app->page->add("movie/movies", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * ANY METHOD mountpoint/searchyear
     *
     * @return object
     */
    public function searchYearActionGet() : object
    {
        $db = $this->app->db;
        $db->connect();

        $title = "Movie database | oophp";
        $resultset = null;

        $year1 = $this->app->request->getGet("year1");
        $year2 = $this->app->request->getGet("year2");

        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $resultset = $db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $resultset = $db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $resultset = $db->executeFetchAll($sql, [$year2]);
        }

        $data = [
            "year1" => $year1,
            "year2" => $year2,
            "resultset" => $resultset,
        ];

        $this->app->page->add("movie/menu");
        $this->app->page->add("movie/search-year", $data);
        $this->app->page->add("movie/movies", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the movies method action, it handles:
     * GET METHOD mountpoint/movie-select
     *
     * @return object
     */
    public function movieSelectActionGet() : object
    {
        $db = $this->app->db;
        $db->connect();

        $title = "Movie database | oophp";
        $resultset = null;

        $sql = "SELECT id, title FROM movie;";
        $movies = $db->executeFetchAll($sql);

        $data = [
            "resultset" => $resultset,
            "movies" => $movies,
        ];

        $this->app->page->add("movie/menu");
        $this->app->page->add("movie/movie-select", $data);
        $this->app->page->add("movie/movies", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the movies method action, it handles:
     * POST METHOD mountpoint/movie-edit
     *
     * @return object
     */
    public function movieSelectActionPost() : object
    {
        $db = $this->app->db;
        $db->connect();

        $movieId = esc($this->app->request->getPost("movieId"));

        if ($this->app->request->getPost("doDelete")) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->execute($sql, [$movieId]);
            return $this->app->response->redirect("movie/movie-select");
        } elseif ($this->app->request->getPost("doAdd")) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $db->execute($sql, ["A title", 2017, "img/noimage.png"]);
            $movieId = $db->lastInsertId();
            return $this->app->response->redirect("movie/movie-edit?movieId=$movieId");
        } elseif ($this->app->request->getPost("doEdit") && is_numeric($movieId)) {
            return $this->app->response->redirect("movie/movie-edit?movieId=$movieId");
        }
    }


    /**
     * This is the movies method action, it handles:
     * GET METHOD mountpoint/movie-edit
     *
     * @return object
     */
    public function movieEditActionGet() : object
    {
        $db = $this->app->db;
        $db->connect();

        $title = "Movie database | oophp";
        $movieId = esc($this->app->request->getGet("movieId"));

        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];

        $data = [
            "movie" => $movie,
        ];

        $this->app->page->add("movie/menu");
        $this->app->page->add("movie/movie-edit", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the movies method action, it handles:
     * POST METHOD mountpoint/movie-edit
     *
     * @return object
     */
    public function movieEditActionPost() : object
    {
        $db = $this->app->db;
        $db->connect();

        $title = "Movie database | oophp";

        $movieId    = esc($this->app->request->getPost("movieId"));
        $movieTitle = esc($this->app->request->getPost("movieTitle"));
        $movieYear  = esc($this->app->request->getPost("movieYear"));
        $movieImage = esc($this->app->request->getPost("movieImage"));

        if ($this->app->request->getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
            return $this->app->response->redirect("movie/movie-edit?movieId=$movieId");
        }

        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];


        $data = [
            "movie" => $movie,
        ];

        $this->app->page->add("movie/menu");
        $this->app->page->add("movie/movie-edit", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the debug method action, it handles:
     * GET METHOD mountpoint/reset
     *
     * @return object
     */
    public function resetActionGet() : object
    {
        $title = "Movie database | oophp";

        $this->app->page->add("movie/menu");
        $this->app->page->add("movie/reset");

        return $this->app->page->render([
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
            $db = $this->app->db;
            $db->connect();

            $sql = "DELETE FROM movie;";
            $db->execute($sql);

            $sql = "INSERT INTO `movie` (`title`, `year`, `image`) VALUES
                ('Pulp fiction', 1994, 'img/pulp-fiction.jpg'),
                ('American Pie', 1999, 'img/american-pie.jpg'),
                ('Pokémon The Movie 2000', 1999, 'img/pokemon.jpg'),
                ('Kopps', 2003, 'img/kopps.jpg'),
                ('From Dusk Till Dawn', 1996, 'img/from-dusk-till-dawn.jpg')";
            $db->execute($sql);
        }

        return $this->app->response->redirect("movie/movies");
    }
}
