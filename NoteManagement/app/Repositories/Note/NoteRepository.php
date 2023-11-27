<?php

namespace App\Repositories\Note;

use App\Interfaces\Note\NoteRepositoryInterface;
use App\Http\Resources\NoteResource;
use App\Traits\ResponseTrait;
use App\Models\Note;

class NoteRepository implements NoteRepositoryInterface
{

    use ResponseTrait;


    public function getAllNotes()
    {
        $notes = Note::all();
        return $this->successResponse(NoteResource::collection($notes), 'OK');
    }


    public function getNoteById($noteId)
    {
        $note = Note::find($noteId);

        return $note
            ? $this->successResponse(new NoteResource($note), 'OK')
            : $this->errorResponse('Note not found', 404);
    }


    public function createNote($validatedData)
    {
        $note = Note::create($validatedData);

        return $this->successResponse(new NoteResource($note), 'Note created successfully', 201);
    }


    public function updateNote($validatedData, $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return $this->errorResponse('Note not found', 404);
        }

        $note->update($validatedData);

        return $this->successResponse(new NoteResource($note), 'Note updated successfully', 201);
    }


    public function deleteNote($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return $this->errorResponse('Note not found', 404);
        }

        $note->delete();

        return $this->successResponse($note, 'Note deleted successfully');
    }
}