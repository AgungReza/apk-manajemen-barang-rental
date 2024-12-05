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
    public function list()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();

        return view('dashboard/listcustomer', ['customers' => $customers]);
    }

    public function search()
    {
        $customerModel = new CustomerModel();
        $query = $this->request->getVar('q');

        if ($query) {
            $customers = $customerModel->like('nama_customer', $query)->findAll();
        } else {
            $customers = $customerModel->findAll();
        }

        return view('dashboard/listcustomer', [
            'customers' => $customers,
            'q' => $query,
        ]);
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Customer dengan ID $id tidak ditemukan.");
        }

        return view('dashboard/editcustomer', ['customer' => $customer]);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();

        $validation = $this->validate([
            'nama_customer' => 'required',
            'email' => "required|valid_email|is_unique[customer.email,customer_id,{$id}]",
            'nik_nis_nim' => 'required',
            'alamat' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $customerModel->update($id, [
            'nama_customer' => $this->request->getVar('nama_customer'),
            'email' => $this->request->getVar('email'),
            'nik_nis_nim' => $this->request->getVar('nik_nis_nim'),
            'alamat' => $this->request->getVar('alamat'),
            'kelas' => $this->request->getVar('kelas'),
            'jurusan' => $this->request->getVar('jurusan'),
        ]);

        return redirect()->to('/listcustomer')->with('success', 'Customer berhasil diupdate!');
    }

    public function delete($id)
    {
        $customerModel = new CustomerModel();
        $customerModel->delete($id);

        return redirect()->to('/listcustomer')->with('success', 'Customer berhasil dihapus!');
    }
}
