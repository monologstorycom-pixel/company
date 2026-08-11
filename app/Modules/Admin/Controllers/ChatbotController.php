<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatbotRuleRequest;
use App\Http\Requests\UpdateChatbotRuleRequest;
use App\Models\ChatbotRule;
use App\Models\ChatHistory;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Display a listing of chatbot rules.
     */
    public function index()
    {
        $this->authorize('view chatbot');

        $rules = ChatbotRule::orderBy('priority', 'desc')->orderBy('id', 'desc')->paginate(15);
        return view('admin.chatbot.index', compact('rules'));
    }

    /**
     * Show the form for creating a new chatbot rule.
     */
    public function create()
    {
        $this->authorize('create chatbot');

        return view('admin.chatbot.create');
    }

    /**
     * Store a newly created chatbot rule in storage.
     */
    public function store(StoreChatbotRuleRequest $request)
    {
        $validated = $request->validated();

        ChatbotRule::create([
            'keyword' => $validated['keyword'],
            'response' => $validated['response'],
            'type' => $validated['type'],
            'priority' => $validated['priority'] ?? 5,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.chatbot.index')
            ->with('success', 'Chatbot rule created successfully.');
    }

    /**
     * Display the specified chatbot rule.
     */
    public function show(ChatbotRule $chatbotRule)
    {
        $this->authorize('view chatbot');

        return view('admin.chatbot.show', compact('chatbotRule'));
    }

    /**
     * Show the form for editing the specified chatbot rule.
     */
    public function edit(ChatbotRule $chatbotRule)
    {
        $this->authorize('edit chatbot');

        return view('admin.chatbot.edit', compact('chatbotRule'));
    }

    /**
     * Update the specified chatbot rule in storage.
     */
    public function update(UpdateChatbotRuleRequest $request, ChatbotRule $chatbotRule)
    {
        $validated = $request->validated();

        $chatbotRule->update([
            'keyword' => $validated['keyword'],
            'response' => $validated['response'],
            'type' => $validated['type'],
            'priority' => $validated['priority'] ?? 5,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.chatbot.index')
            ->with('success', 'Chatbot rule updated successfully.');
    }

    /**
     * Remove the specified chatbot rule from storage.
     */
    public function destroy(ChatbotRule $chatbotRule)
    {
        $this->authorize('delete chatbot');

        $chatbotRule->delete();

        return redirect()->route('admin.chatbot.index')
            ->with('success', 'Chatbot rule deleted successfully.');
    }

    /**
     * Display chatbot conversation history.
     */
    public function history()
    {
        // Allow users with 'view chatbot' permission OR Marketing role to access history
        $this->authorize('view chatbot');

        $histories = ChatHistory::with(['user', 'rule'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.chatbot.history', compact('histories'));
    }
}
