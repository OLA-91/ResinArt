<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Images::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->onlyOnDetail()
                ->onlyOnIndex(),
            ImageField::new('name')

                ->setBasePath('/public/assets/uploads/products')
                ->setUploadDir('/public/assets/uploads/products')
                ->onlyOnForms()


        ];
    }

}
