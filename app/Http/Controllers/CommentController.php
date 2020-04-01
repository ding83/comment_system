<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Snipe\BanBuilder\CensorWords;
use App\Comment;
use DB;
use Exception;

class CommentController extends Controller
{
    /** get request comment **/
    public function getCommentIndex($id=null, Request $request)
    {
      try {
        $data = $request->all();
        $buildComment = [];

        if (empty($data['post_id'])) {
          throw new Exception("post_id is required.");
        }

        $comments = DB::table('comments as c1')
        ->select([
          'c1.comment_id as c1_comment_id',
          'c1.name as c1_name',
          'c1.comment as c1_comment',
          'c1.post_id as c1_post_id',
          'c1.parent_comment_id as c1_parent_comment_id',
          'c2.comment_id as c2_comment_id',
          'c2.name as c2_name',
          'c2.comment as c2_comment',
          'c2.post_id as c2_post_id',
          'c2.parent_comment_id as c2_parent_comment_id',
          'c3.comment_id as c3_comment_id',
          'c3.name as c3_name',
          'c3.comment as c3_comment',
          'c3.post_id as c3_post_id',
          'c3.parent_comment_id as c3_parent_comment_id'
        ])
        ->leftJoin('comments as c2', 'c2.parent_comment_id', '=', 'c1.comment_id')
        ->leftJoin('comments as c3', 'c3.parent_comment_id', '=', 'c2.comment_id')
        ->whereNull('c1.parent_comment_id')
        ->where('c1.post_id', $data['post_id'])
        ->orderBy('c1.created_at', 'desc')
        ->orderBy('c2.created_at', 'desc')
        ->orderBy('c3.created_at', 'desc')
        ->get();

        if (!$comments) {
          return response()->json(['data' => []]);
        }

        $layer1 = [];
        $layer2 = [];
        $layer3 = [];

        foreach ($comments as $commentL1) {
          if (empty($layer1['c1_'.$commentL1->c1_comment_id])) {
            $layer1['c1_'.$commentL1->c1_comment_id] = $this->getC1Data($commentL1);
          }
        }

        foreach ($comments as $commentL2) {

          if (empty($commentL2->c2_comment_id)) {
            continue;
          }

          if (empty($layer2['c2_'.$commentL2->c2_comment_id])) {
            $layer2['c2_'.$commentL2->c2_comment_id] = $this->getC2Data($commentL2);
          }
        }

        foreach ($comments as $commentL3) {
          if (!empty($commentL3->c3_comment_id)) {
            $layer3[] = $this->getC3Data($commentL3);
          }
        }

        if (count($layer3) && count($layer2)) {
          foreach ($layer3 as $l3key => $l3) {
            foreach ($layer2 as $l2key => $l2) {
              if ($l3['parent_comment_id'] == $l2['comment_id']) {
                $layer2[$l2key]['children'][] = $l3;
              }
            }
          }
        }

        if (count($layer2)) {
          foreach ($layer2 as $l2pkey => $l2p) {
            foreach ($layer1 as $l1key => $l1) {
              if ($l2p['parent_comment_id'] == $l1['comment_id']) {
                $layer1[$l1key]['children'][] = $l2p;
              }
            }
          }
        }

        if ($layer1) {
          foreach ($layer1 as $data) {
            $buildComment[] = $data;
          }
        }

        return response()->json(['data' => $buildComment]);

      } catch (Exception $e) {}

      return response()->json(['error' => $e->getMessage()]);
    }

    /** post request comment **/
    public function postCommentIndex(Request $request)
    {
      try {
        $data = $request->all();

        $validator = Validator::make($data, [
           'name' => 'required|string|max:50',
           'comment' => 'required',
           'post_id' => 'required'
       ]);

        if ($validator->fails()) {
          throw new Exception($validator->messages()->first());
        }

        $censor = new CensorWords;
        $name = $censor->censorString($data['name']);
        $comment = $censor->censorString($data['comment']);
        $data['name'] = $name['clean'];
        $data['comment'] = $comment['clean'];

        $comment = new Comment;

        $comment->name = $data['name'];
        $comment->comment = $data['comment'];
        $comment->post_id = $data['post_id'];
        $comment->parent_comment_id = $data['parent_comment_id'] ?? null;

        if (!$comment->save()) {
          throw new Exception("There was error in saving the comment.");
        }

        return response()->json(['data' => 'success']);

      } catch (Exception $e) {}

      return response()->json(['error' => $e->getMessage()]);
    }

    protected function getC1Data($comment)
    {

      if (empty($comment->c1_comment_id)) {
        return [];
      }

      return array(
        'comment_id' => $comment->c1_comment_id,
        'name'    => $comment->c1_name,
        'comment' => $comment->c1_comment,
        'post_id' => $comment->c1_post_id,
        'parent_comment_id' => $comment->c1_parent_comment_id
      );
    }

    protected function getC2Data($comment)
    {

      if (empty($comment->c2_comment_id)) {
        return [];
      }

      return array(
        'comment_id' => $comment->c2_comment_id,
        'name'    => $comment->c2_name,
        'comment' => $comment->c2_comment,
        'post_id' => $comment->c2_post_id,
        'parent_comment_id' => $comment->c2_parent_comment_id
      );
    }

    protected function getC3Data($comment)
    {

      if (empty($comment->c3_comment_id)) {
        return [];
      }

      return array(
        'comment_id' => $comment->c3_comment_id,
        'name'    => $comment->c3_name,
        'comment' => $comment->c3_comment,
        'post_id' => $comment->c3_post_id,
        'parent_comment_id' => $comment->c3_parent_comment_id
      );
    }
}
