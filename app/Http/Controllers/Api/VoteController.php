<?php

namespace App\Http\Controllers\Api;

use App\Facades\VoteStorage;
use App\Helpers\OpenApiHelpers\RequestBodyHelper;
use App\Helpers\OpenApiHelpers\RequestResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\VoteResource;
use App\Models\Vote;
use App\Models\VoteGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class VoteController extends Controller
{
    public const BASE_PATH = parent::BASE_PATH . '/votes';

    public const VOTE = 'Vote';

    #[OA\Get(
        path: self::BASE_PATH . '',
        tags: [self::VOTE],
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'vote', isCollection: true),
        ]
    )]
    public function getVotes()
    {
        return VoteResource::collection(Vote::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(VoteGroup $voteGroup)
    {
        //
    }

    #[OA\Post(
        path: self::BASE_PATH . '',
        tags: [self::VOTE],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'title', type: 'string', example: 'Vote Title'),
                new OA\Property(property: 'description', type: 'string', example: 'Vote Description'),
                new OA\Property(property: 'start_date', type: 'string', format: 'date-time', example: '2023-10-01T00:00:00Z'),
                new OA\Property(property: 'end_date', type: 'string', format: 'date-time', example: '2023-10-31T23:59:59Z'),
                new OA\Property(property: 'logo', type: 'string', format: 'binary', example: 'logo.png'),
            ],
            required: ['title', 'start_date', 'end_date'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'vote'),
        ]
    )]
    public function store(Request $request)
    {
        $request->validate(Vote::validationRules());

        $logoPath = $request->file('logo') ? VoteStorage::put(VOTE_LOGO_PATH, $request->file('logo')) : null;

        $vote = Vote::create([
            'user_id' => $request->user()->id,
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => Carbon::parse($request->input('start_date')),
            'end_date' => Carbon::parse($request->input('end_date')),
            'logo' => $logoPath,
        ]);

        return response()->json([
            'message' => 'Vote created successfully',
            'data' => new VoteResource($vote),
        ]);
    }

    #[OA\Post(
        path: self::BASE_PATH . '/{vote}',
        tags: [self::VOTE],
        parameters: [
            new OA\Parameter(name: 'vote', in: 'path', description: 'Vote id', required: true, example: '1', allowEmptyValue: false),
        ],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'title', type: 'string', example: 'Vote Title'),
                new OA\Property(property: 'description', type: 'string', example: 'Vote Description'),
                new OA\Property(property: 'start_date', type: 'string', format: 'date-time', example: '2023-10-01T00:00:00Z'),
                new OA\Property(property: 'end_date', type: 'string', format: 'date-time', example: '2023-10-31T23:59:59Z'),
                new OA\Property(property: 'logo', type: 'string', format: 'binary', example: 'logo.png'),
            ],
            required: ['title', 'start_date', 'end_date'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'vote'),
        ]
    )]
    public function update(Request $request, Vote $vote)
    {

        $request->validate(Vote::validationRules());

        $logoPath = $request->file('logo') ? VoteStorage::put(VOTE_LOGO_PATH, $request->file('logo')) : null;

        $vote->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => Carbon::parse($request->input('start_date')),
            'end_date' => Carbon::parse($request->input('end_date')),
            'logo' => $logoPath,
        ]);

        $vote->deleteLogo();

        return response()->json([
            'message' => 'Vote updated successfully',
            'data' => new VoteResource($vote),
        ]);
    }

    #[OA\Delete(
        path: self::BASE_PATH . '/{vote}',
        tags: [self::VOTE],
        parameters: [
            new OA\Parameter(name: 'vote', in: 'path', description: 'Vote id', required: true, example: 1),
        ],
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'vote'),
        ]
    )]
    public function destroy(Vote $vote)
    {
        $vote->deleteLogo();

        $vote->delete();

        return response()->json([
            'message' => 'Vote deleted successfully',
            'data' => new VoteResource($vote),
        ]);
    }
}
