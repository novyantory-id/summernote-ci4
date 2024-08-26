<?php 

public function uploadImages()
    {
        $files = $this->request->getFiles();
        $uploadedFiles = $files['images'] ?? [];
        $imageUrls = [];

        foreach ($uploadedFiles as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $fileName = $file->getRandomName();
                $filePath = ROOTPATH . 'public/assets/images/artikel/' . $fileName;
                $file->move(ROOTPATH . 'public/assets/images/artikel', $fileName);
                $imageUrls[] = base_url('assets/images/artikel/' . $fileName);
            }
        }

        return $this->response->setJSON(['images' => $imageUrls]);
    }

public function deleteGambar()
    {
        $imageUrl = $this->request->getPost('imageUrl');

        $imagePath = str_replace(base_url(), '', $imageUrl);
        $fullPath = ROOTPATH . 'public/' . $imagePath;
        if (file_exists($fullPath)) {
            if (unlink($fullPath)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Image deleted successfully']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete image']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Image not found'], 404);
        }
    }

 ?>
