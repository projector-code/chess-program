$(document).ready(function(){
    // Disable right-click
    document.addEventListener('contextmenu', (e) => e.preventDefault());

    // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
    document.onkeydown = (e) => {
        if (e.key == 123) {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'I') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'C') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.shiftKey && e.key == 'J') {
            e.preventDefault();
        }
        if (e.ctrlKey && e.key == 'U') {
            e.preventDefault();
        }
    };
    
    /*
    * Function to move the piece display.
    */
    function performMovePiece(coordinateFrom, coordinateTo, result) {
        var piece_id = $("#"+coordinateFrom).attr("data-chess-piece-id");
        var piece_name = $("#"+coordinateFrom).attr("data-chess-piece-name");
        var piece_color = $("#"+coordinateFrom).attr("data-chess-piece-color");

        $("#"+coordinateFrom).attr("data-chess-piece-id", 0);
        $("#"+coordinateFrom).attr("data-chess-piece-name", "");
        $("#"+coordinateFrom).attr("data-chess-piece-color", "");
        $("#"+coordinateFrom).attr("data-chess-piece-is-pawn-first-move", 0);
        $("#"+coordinateFrom).text("");
        
        $("#"+coordinateTo).attr("data-chess-piece-id", piece_id);
        $("#"+coordinateTo).attr("data-chess-piece-name", piece_name);
        $("#"+coordinateTo).attr("data-chess-piece-color", piece_color);
        $("#"+coordinateTo).attr("data-chess-piece-is-pawn-first-move", 0);
        $("#"+coordinateTo).removeAttr("class")
        $("#"+coordinateTo).addClass("square-content");
        $("#"+coordinateTo).addClass(piece_color);
        $("#"+coordinateTo).text(piece_name);

        $("#player-turn").text(result["player_turn"]);
    }

    /*
    * Function when King piece captured.
    */
    function performEndGame(result) {
        $("#game-status").text(result["message"]);
        $("#move-piece").hide();
    }

    /*
    * Function to call ajax MovePiece funtion.
    */
    function movePiece(coordinateFrom, coordinateTo) {
        var square_id = $("#"+coordinateFrom).attr("id");
        var piece_id = $("#"+coordinateFrom).attr("data-chess-piece-id");
        var piece_name = $("#"+coordinateFrom).attr("data-chess-piece-name");
        var piece_color = $("#"+coordinateFrom).attr("data-chess-piece-color");
        var is_pawn_first_move = $("#"+coordinateFrom).attr("data-chess-piece-is-pawn-first-move");
        var from_coordinate_x = $("#"+coordinateFrom).attr("data-coordinate-x");
        var from_coordinate_y = $("#"+coordinateFrom).attr("data-coordinate-y");

        var to_square_id = $("#"+coordinateTo).attr("id");
        var to_piece_id = $("#"+coordinateTo).attr("data-chess-piece-id");
        var to_piece_name = $("#"+coordinateTo).attr("data-chess-piece-name");
        var to_piece_color = $("#"+coordinateTo).attr("data-chess-piece-color");
        var to_coordinate_x = $("#"+coordinateTo).attr("data-coordinate-x");
        var to_coordinate_y = $("#"+coordinateTo).attr("data-coordinate-y");

        $.ajax({
            url: "move-piece",
            type: "POST",
            data: {
                square_id: square_id,
                piece_id: piece_id,
                piece_name: piece_name,
                piece_color: piece_color,
                from_coordinate_x: from_coordinate_x,
                from_coordinate_y: from_coordinate_y,
                to_coordinate_x: to_coordinate_x,
                to_coordinate_y: to_coordinate_y,
                to_square_id: to_square_id,
                to_piece_id: to_piece_id,
                to_piece_name: to_piece_name,
                to_piece_color: to_piece_color,
                is_pawn_first_move: is_pawn_first_move
            },
            dataType: "json",
            success: function (result) {
                // To perform move the chess piece.
                performMovePiece(coordinateFrom, coordinateTo, result);

                // If the game is over.
                if (result["game_over"] != undefined) {
                    performEndGame(result);
                }
            },
            error: function(response,status,errorThrown) {
                if(response["responseJSON"]["code"] == 400) {
                    alert(response["responseJSON"]["message"]);
                } else {
                    alert(JSON.stringify(response));
                }
            }
        });
    }

    /*
    * Function when [Move Piece] button clicked.
    */
    $("#move-piece").click(function(){
        // Check [From] value
        var coordinateFrom = $("#coordinate-from").val();
        if (coordinateFrom == "") {
            alert("empty [From] value");
            return false;
        }
        var pieceNameFrom = $("#"+coordinateFrom).attr("data-chess-piece-name");
        if (pieceNameFrom == undefined || pieceNameFrom == "") {
            alert("invalid [From] value");
            return false;
        }

        // Check [From] color with player turn
        var pieceFromColor =$("#"+coordinateFrom).attr("data-chess-piece-color");
        var playerTurn = $("#player-turn").text();
        if (pieceFromColor != playerTurn) {
            alert("incorrect [From] chess piece color");
            return false;
        }

        // Check [To] value
        var coordinateTo = $("#coordinate-to").val();
        if (coordinateTo == "") {
            alert("empty [To] value");
            return false;
        }
        var pieceNameTo = $("#"+coordinateTo).attr("data-chess-piece-name");
        if (pieceNameTo == undefined) {
            alert("invalid [To] value");
            return false;
        }

        // Compare [From] and [To] value
        if (coordinateFrom == coordinateTo) {
            alert("[From] and [To] same value");
            return false;
        }

        movePiece(coordinateFrom, coordinateTo);
    });

    /*
    * Function when [Restart Game] button clicked.
    */
    $("#restart-game").click(function(){
        $.ajax({
            url: "restart-game",
            type: "GET",
            dataType: "json",
            success: function (result) {
                $(document).ajaxStop(function(){
                    window.location.reload();
                });
            },
            error: function(response,status,errorThrown) {
                alert(JSON.stringify(response));
            }
        });
    });
});