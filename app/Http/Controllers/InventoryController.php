<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{

    public function getInventory(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if the user is authenticated
        try {
            $player = Auth::guard('api')->user();

            $inventory = $player->inventory;

            return response()->json($inventory);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function manageItem(Request $request, $itemId, $quantity, $operation)
    {
        $player = $request->user();
        $existingItem = $this->getExistingItem($player->id, $itemId);

        if ($operation === 'add') {
            return $this->addItemOperation($player, $existingItem, $itemId, $quantity);
        } elseif ($operation === 'remove') {
            return $this->removeItemOperation($player, $existingItem, $itemId, $quantity);
        } else {
            return response()->json("Invalid operation", 400);
        }
    }

    public function addItem(Request $request, $itemId, $quantity)
    {
        return $this->manageItem($request, $itemId, $quantity, 'add');
    }

    public function removeItem(Request $request, $itemId, $quantity)
    {
        return $this->manageItem($request, $itemId, $quantity, 'remove');
    }

    private function getExistingItem($playerId, $itemId)
    {
        return Player::where('id', $playerId)
            ->whereHas('inventory', function ($q) use ($itemId) {
                $q->where('inventory.item_id', $itemId);
            })->first();
    }

    private function addItemOperation($player, $existingItem, $itemId, $quantity)
    {
        if (!$existingItem) {
            $player->inventory()->syncWithoutDetaching([$itemId => [
                "quantity" => $quantity,
            ]]);

            return response()->json("Item added");
        } else {
            $currentQuantity = $existingItem->inventory()->where('item_id', $itemId)->first()->pivot->quantity;
            $newQuantity = $currentQuantity + $quantity;
            $existingItem->inventory()->updateExistingPivot($itemId, ['quantity' => $newQuantity]);

            return response()->json("Updated item");
        }
    }

    private function removeItemOperation($player, $existingItem, $itemId, $quantity)
    {
        if ($existingItem) {
            $currentQuantity = $existingItem->inventory()->where('item_id', $itemId)->first()->pivot->quantity;
            $newQuantity = max(0, $currentQuantity - $quantity);

            if ($newQuantity === 0) {
                $existingItem->inventory()->detach($itemId);
                return response()->json("Item removed from inventory");
            } else {
                $existingItem->inventory()->updateExistingPivot($itemId, ['quantity' => $newQuantity]);
                return response()->json("Updated item");
            }
        } else {
            return response()->json("Player doesn't have this item", 404);
        }
    }
}
