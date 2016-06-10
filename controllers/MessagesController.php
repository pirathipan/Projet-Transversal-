<?php

class MessagesController{

	public function indexAction(){
		$conversation = new MessagesModel();
		$conversations = $conversation->GetUserConversations($_SESSION['user_id']);
		Core::Render('Messages', 'index', [
			'conversations' => $conversations
		]);
	}

	public function conversationAction($id){
		$conversation = new MessagesModel();
		$messages = $conversation->GetUserMessages($id);
		$convPermissions = get_object_vars($conversation->GetConversationsPermissions($id));
		if($_SESSION['user_id'] == $convPermissions['author_id'] || $_SESSION['user_id'] == $convPermissions['user_id']){
			Core::Render('Messages', 'messages', [
				'messages' => $messages
			]);
		} else {
			Core::Response(['error' => 'You cannot access this conversation'], 401);
		}

	}

	public function newAction(){
		$conversation = new MessagesModel();
		if(isset($_POST['authorId']) && $_POST['convId'] && $_POST['content']){
			$date = date('d/m/Y');
			$conversation->AddMessage($_POST['content'], $date, $_POST['authorId'], $_POST['convId']);
			Core::Response(['success' => true, 'message' => 'Message created', 'post' => $_POST], 200);
		} else {
			Core::Response(['error' => 'Empty form'], 400);
		}
	}

	public function newconvAction(){
		$conversation = new MessagesModel();
		$userModel = new UserModel();
		$users = $userModel->GetAllUsers();
		if(isset($_POST['user_id'])){
			$conversation->CreateConversation($_SESSION['user_id'], $_POST['user_id']);
			Core::Response(['message' => 'Creating conversation'], 200);
		} else {
			Core::Render('Messages','newConv',[
				'users' => $users
			]);
		}

	}

	public function deleteAction(){
		global $id;
		$messagesModel = new MessagesModel();
		$messagesModel->DeleteConversations($id);
		Core::Response(['message' => 'Conversation and messages deleted'], 200);

	}
}