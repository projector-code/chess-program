<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Chess Program</title>
        <link rel="stylesheet" href="{{ asset('css/chess.css') }}">
        <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
        <script src="{{asset('js/chess.js')}}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </head>
    <body>
        <div>
            <h1>Chess Program</h1>
            <h4 id="game-status">{{ $chess['game_status'] }} {{ $chess['note'] }} </h4>
            <h4>[P = pawn; B = bishop; N = knight; R = rook; Q = queen; K = king]</h4>
            <div id="chess-board">
                    @for($vertical_coordinate = 8; $vertical_coordinate > 0; $vertical_coordinate--)
                        @for($horizontal_coordinate = 1; $horizontal_coordinate <= 8; $horizontal_coordinate++)
                        @php
                            $background = ($vertical_coordinate + $horizontal_coordinate) % 2 === 0 ? 'background-dark' : 'background-light';
                            $id = $coordinate_x_char[$horizontal_coordinate] . $vertical_coordinate;
                            
                            $chess_piece_id = 0;
                            $name = "";
                            $color = "light";
                            
                            // To put chess pieces to the board.
                            foreach ($chess_pieces as $chess_piece) {
                                if ($chess_piece['coordinate_id'] == $id) {
                                    $chess_piece_id = $chess_piece['id'];
                                    $name = $chess_piece['name'];
                                    $color = $chess_piece['color'];
                                    $is_pawn_first_move = $chess_piece['is_pawn_first_move'];
                                }
                            }
                        @endphp

                        <div class="board-square {{ $background }}">
                            <div class="square-id">{{ $id }}</div>
                            <div id="{{ $id }}" class="square-content {{ $color }}"
                                data-coordinate-x="{{ $horizontal_coordinate }}"
                                data-coordinate-y="{{ $vertical_coordinate }}"
                                data-chess-piece-id="{{ $chess_piece_id }}"
                                data-chess-piece-name="{{ $name }}"
                                data-chess-piece-color="{{ $color }}"
                                data-chess-piece-is-pawn-first-move="{{ $is_pawn_first_move }}">
                                {{ $name }}
                            </div>
                        </div>
                        @endfor
                    @endfor
                </tr>
            </div>
            <h4>Player Turn: <span id="player-turn">{{ $chess['player_turn'] }}<span></h4>
            <div>
                <label>From: </label><input id="coordinate-from" type="text" placeholder="a1" maxlength="2" />
                <label>To: </label><input id="coordinate-to" type="text" placeholder="h8" maxlength="2" />
                @if ($chess['game_over'] == 0)
                <input id="move-piece" type="button" value="Move Piece" onclick="msg()"/>
                @endif
            </div>
            <p>
                <input id="restart-game" type="button" value="Restart Game" onclick="restart-game"/>
            </p>
        </div>
    </body>
    <script>
        // $('#start-chess').click(function(){
        //     alert("Hello world!");
        // });

        // function msg() {
        //     alert("Hello world!");
        // }
    </script>
</html>