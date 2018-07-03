<?php

namespace App\Http\Controllers;

use App\Bot;
use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Shows the bot entry with the given ID if it exists.
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bot = Bot::where('id', $id)->first();
        
        if ($bot == null) {
            return $this->sendError(404, 'Found no bot resource with the given ID.');
        }

        return response()->json([
            'status' => 200,
            'data' => $bot->toArray()
        ]);
    }

    /**
     * Valids the bot request, if everything is A-OK, the data is stored in the database.
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id     
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (! preg_match('/^[0-9]{18,}$/', $id)) {
            return $this->sendError(400, 'Invalid ID given, the ID must be a numeric string that is 18 or more characters long.');
        }

        if (! preg_match('/^(AvaIre v+[0-9]+\.+[0-9]+\.+[0-9]+)$/', $request->headers->get('user-agent'))) {
            return $this->sendError(400, 'Invalid user agent given, ignoring request.');
        }

        if ($request->headers->get('content-type') !== 'application/json') {
            return $this->sendError(400, 'Invalid content type header given, must be application/json.');
        }

        if (! $this->validateShard($request->get('shards'))) {
            return $this->sendError(400, 'Invalid shards format given, ignoring request.');
        }

        if (! $this->validateBot($request->get('bot'))) {
            return $this->sendError(400, 'Invalid bot format given, ignoring request.');
        }

        $data = [
            'id' => $id,
            'name' => trim($request->get('bot')['name']),
            'avatar' => trim($request->get('bot')['avatar']),
            'version' => explode(' ', $request->headers->get('user-agent'))[1],
            'shards' => $request->get('shards'),
        ];

        $bot = Bot::where('id', $id)->first();
        ($bot == null) ?
            Bot::create($data) : $bot->update($data);

        return response()->json([
            'stats' => 200,
            'message' => 'The payload has been saved successfully.'
        ], 200);
    }

    /**
     * Sends an error response with a status and reason.
     * 
     * @param  int    $status
     * @param  string $reason
     * @return \Illuminate\Http\Response
     */
    protected function sendError($status, $reason)
    {
        return response()->json(compact('status', 'reason'), $status);
    }

    /**
     * Valids the shard data from the payload.
     *
     * @param  array $shards
     * @return boolean
     */
    protected function validateShard($shards)
    {
        if ($shards == null) {
            return false;
        }

        foreach ((array) $shards as $key => $shard) {
            if (! is_int($key) && $key > -1) {
                return false;
            }

            if (! isset($shard['channels'], $shard['guilds'], $shard['latency'], $shard['id'], $shard['users'])) {
                return false;
            }

            if (! (is_int($shard['channels']) 
                && is_int($shard['guilds'])
                && is_int($shard['latency'])
                && is_int($shard['id'])
                && is_int($shard['users']))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Valids the bot data from the payload.
     *
     * @param  array $bot
     * @return boolean
     */
    protected function validateBot($bot)
    {
        if ($bot == null || ! is_array($bot)) {
            return false;
        }

        return isset($bot['name'])
            && ! is_null($bot['name'])
            && isset($bot['avatar'])
            && ! is_null($bot['avatar'])
            && preg_match('/[a-f0-9]{32}/', $bot['avatar']);
    }
}
