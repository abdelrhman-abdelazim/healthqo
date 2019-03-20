<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Comment;
use function GuzzleHttp\json_decode;
use Validator;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = ($request->limit) ? $request->limit : 15;
        $post_id = $request->post;
        
        //get all comments
        $comments = Comment::where("post_id", $post_id)->orderBy('id', 'DESC')->with("user:id,name,avatar")->paginate($limit)->toArray();
        
        // customize pagination
        $pagination = $comments;
        unset($pagination['data']);
        
        // return the output
        $data = array_merge(['comments' => $comments['data']], $pagination);
        return response()->json(['status' => 200, 'msg' => 'comments fetched', 'data' => $data], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validation
        $rules = [
            'body' => 'required',
            'post' => 'required',
            'user' => 'required',
        ];

        // validate these rules
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->errors(), 'data' => null], 401);
        }


        //imp
        $body = $request->body;
        $post_id = $request->post;
        $user_id = $request->user;


        // create the comment
        $comment = new Comment([
            'body' => $body,
            'post_id' => $post_id,
            'user_id' => $user_id,
        ]);

        // try to save it
        if ($comment->save()) {
            $comment = Comment::where('id', $comment->id);
            $comment = $comment->with("user:id,username,avatar")->get();
            return response()->json(['status' => 201, 'msg' => 'comment created!', 'data' => $comment], 201);
        } else {
            return response()->json(['status' => 500, 'msg' => " can 't create the comment", ' data ' => $comment], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::with("user:id,username,avatar")->find($id);

        if ($comment) {
            return response()->json([' status ' => 200, ' msg ' => ' comment found !', ' data ' => $comment], 200);
        } else {
            return response()->json([' status ' => 404, ' msg ' => "comment not found!", ' data ' => $comment], 404);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if ($comment) {

            $comment->body = $request->body;

            if ($comment->save()) {
                return response()->json(['status' => 200, 'msg' => ' comment updated ', ' data ' => $comment], 200);
            } else {
                return response()->json(['status' => 500, 'msg' => "comment can't be updated!", 'data' => $comment], 500);
            }
        } else {
            return response()->json(['status' => 404, 'msg' => " comment not found!", 'data' => $comment], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if ($comment) {
            if ($comment->delete()) {
                return response()->json(['status' => 200, 'msg' => 'comment deleted!', 'data' => $comment], 200);
            } else {
                return response()->json(['status' => 500, 'msg' => " comment can 't be deleted!", ' data ' => $comment], 500);
            }
        } else {
            return response()->json([' status ' => 404, ' msg ' => "comment not found!", ' data' => $comment], 404);
        }

    }

}
