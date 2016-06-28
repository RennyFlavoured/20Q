<?php

namespace App\Http\Controllers;

use App\Round;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;

use App\Http\Controllers\PlayerContext;

use App\LobbyLive;

class GameController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /** @var playerContext */
    private $playerContext;

    public function __construct(PlayerContext $playerContext)
    {
        $this->playerContext = $playerContext;
    }

    public function gameStatus(Request $request)
    {
        $this->validate( $request, [
            'lobbyId'       => 'required|numeric',
            'roundId'       => 'required|numeric'
        ]);

        $roundDetails = Round::getCurrentRoundDetails(
            $request->input('lobbyId', 'null'),
            $request->input('roundId', 'null')
        );
        
        if(!$roundDetails)
        {
            abort(404, 'No such game round exists.');
        }

        return [
            'lobbyId' => $roundDetails->LobbyId,
            'roundId' => $roundDetails->RoundId,
            'playerLives' => $roundDetails->Lives,
            'answers' => $roundDetails->Answers,
            'createdAt' => $roundDetails->created_at,
            'roundEnd' => $roundDetails->FinishDate

        ];
    }

    public function gameAnswer(Request $request)
    {
        $this->validate( $request, [
            'lobbyId'       => 'required|numeric',
            'roundId'       => 'required|numeric',
            'answer'       => 'required|numeric',
        ]);

        $roundDetails = Round::getCurrentRoundDetails(
            $request->input('lobbyId', 'null'),
            $request->input('roundId', 'null')
        );

        if(!$roundDetails)
        {
            $roundDetails = Round::createRound(
                $request->input('lobbyId', 'null'),
                $request->input('roundId', 'null')
            );
        }

        $roundDetails->Answers = $this->compileAnswers($request->input('answer', 'null'), $roundDetails);
        $roundDetails->save();

        return [
            'lobbyId' => $roundDetails->LobbyId,
            'roundId' => $roundDetails->RoundId,
            'playerLives' => 'dunno!',
            'answers' => $roundDetails->Answers,
            'createdAt' => $roundDetails->created_at,
            'roundEnd' => $roundDetails->FinishDate

        ];
    }

    private function compileAnswers($answer, $roundDetails)
    {
        $currentAnswers = json_decode($roundDetails->Answers, true);
        $player = $this->playerContext->getPlayerKey();

        return json_encode($currentAnswers[] = [
            $player => $answer
        ]);
    }
}
