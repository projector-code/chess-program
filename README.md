# Chess Program

--- 
<h2>Requirement</h2>

1. PHP
2. Mysql
3. Laravel

--- 
<h2>Structure Folder and Custom File</h2>

<pre>
-> chess-program
    -> .env
    -> .env.testing
    -> phpunit.xml
    -> favicon.ico
    -> app
        -> Http
            -> Controllers
                -> BishopController.php
                -> ChessController.php
                -> ChessPieceController.php
                -> KingController.php
                -> KnightController.php
                -> PawnController.php
                -> QueenController.php
                -> RookController.php
        -> Models
            -> Chess.php
            -> ChessPiece.php
    -> database
        -> migrations
            -> 2025_05_07_021457_create_chess_pieces_table.php
            -> 2025_05_07_023438_create_chesses_table.php
    -> public
        -> css
            -> chess.css
        -> js
            -> chess.js
            -> jquery-3.7.1.min.js
    -> routes
        -> web.php
    -> tests
        -> Feature
            -> BishopTest.php
            -> ChessTest.php
            -> KingTest.php
            -> KnightTest.php
            -> PawnTest.php
            -> QueenTest.php
            -> RookTest.php
</pre>

--- 
<h2>Preparation</h2>

1. Clone the project.
2. Run command line<pre>composer install</pre>
3. Rename [.env.example] file to [.env], then update the variable value based on your local configuration.
4. Database<br />
   a. Create database name: [_chess_db_].<br />
   b. Migrate the table with command line <pre>php artisan migrate</pre>
5. Update the variable value on [phpunit.xml] file based on your local configuration.


--- 
<h2>Run The Program</h2>

1. To run the Unit Test with command line <pre>php artisan test</pre>
2. To run the Program with command line <pre>php artisan serve</pre>
3. Open http://127.0.0.1:8000/ 
