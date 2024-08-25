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

 ?>