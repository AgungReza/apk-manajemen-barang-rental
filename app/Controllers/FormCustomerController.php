<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class FormCustomerController extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();
        $customerId = $this->generateUniqueCustomerId($customerModel);

        return view('dashboard/formcustomer', ['customer_id' => $customerId]);
    }

    public function save()
    {
        $customerModel = new CustomerModel();

        $validation = $this->validate([
            'nama_customer' => 'required',
            'email' => 'required|valid_email|is_unique[customer.email]',
            'nik_nis_nim' => 'required',
            'alamat' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $customerModel->save([
            'customer_id' => $this->request->getPost('customer_id'),
            'nama_customer' => $this->request->getVar('nama_customer'),
            'email' => $this->request->getVar('email'),
            'nik_nis_nim' => $this->request->getVar('nik_nis_nim'),
            'alamat' => $this->request->getVar('alamat'),
            'kelas' => $this->request->getVar('kelas'),
            'jurusan' => $this->request->getVar('jurusan'),
        ]);

        return redirect()->to('/formcustomer')->with('success', 'Customer berhasil didaftarkan!');
    }

    private function generateUniqueCustomerId($customerModel)
    {
        do {
            $randomId = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4));
        } while ($customerModel->where('customer_id', $randomId)->countAllResults() > 0);

        return $randomId;
    }
}
