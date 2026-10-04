<?php

namespace App\Controllers;

use App\Models\UserModel;

class Staff extends BaseController
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index(): string
    {
        $staff = $this->model->orderBy('created_at', 'DESC')->findAll();
        return view('staff', ['staff' => $staff]);
    }

    public function store()
    {
        $avatarFilename = null;

        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile && $avatarFile->isValid() && ! $avatarFile->hasMoved()) {
            $newName        = $avatarFile->getRandomName();
            $avatarFile->move(FCPATH . 'uploads/avatars', $newName);
            $avatarFilename = $newName;
        }

        $this->model->insert([
            'username'   => $this->request->getPost('username'),
            'full_name'  => $this->request->getPost('full_name'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'avatar'     => $avatarFilename,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/staff')->with('success', 'Staff member added successfully.');
    }

    public function edit(int $id): string
    {
        $member = $this->model->find($id);
        $staff  = $this->model->orderBy('created_at', 'DESC')->findAll();
        return view('staff', ['staff' => $staff, 'editStaff' => $member]);
    }

    public function update(int $id)
    {
        $member = $this->model->find($id);

        $data = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        // Only update password if a new one was provided
        $newPass = $this->request->getPost('password');
        if ($newPass && trim($newPass) !== '') {
            $data['password'] = password_hash($newPass, PASSWORD_DEFAULT);
        }

        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile && $avatarFile->isValid() && ! $avatarFile->hasMoved()) {
            if ($member['avatar'] && file_exists(FCPATH . 'uploads/avatars/' . $member['avatar'])) {
                unlink(FCPATH . 'uploads/avatars/' . $member['avatar']);
            }
            $newName        = $avatarFile->getRandomName();
            $avatarFile->move(FCPATH . 'uploads/avatars', $newName);
            $data['avatar'] = $newName;

            // Update session if editing yourself
            if (session()->get('user_id') == $id) {
                session()->set('avatar', $newName);
            }
        }

        $this->model->update($id, $data);

        // Refresh session name if editing self
        if (session()->get('user_id') == $id) {
            session()->set('user_name', $data['full_name']);
            session()->set('username', $data['username']);
        }

        return redirect()->to('/staff')->with('success', 'Staff member updated successfully.');
    }

    public function delete(int $id)
    {
        // Prevent deleting yourself
        if (session()->get('user_id') == $id) {
            return redirect()->to('/staff')->with('error', 'You cannot delete your own account.');
        }
        $member = $this->model->find($id);
        if ($member && $member['avatar'] && file_exists(FCPATH . 'uploads/avatars/' . $member['avatar'])) {
            unlink(FCPATH . 'uploads/avatars/' . $member['avatar']);
        }
        $this->model->delete($id);
        return redirect()->to('/staff')->with('success', 'Staff member deleted successfully.');
    }
}
