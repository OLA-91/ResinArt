<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductsCrudController extends AbstractCrudController
{
    private $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository){
        $this->categoriesRepository = $categoriesRepository;
    }
    
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }
    
    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('name'),
            TextField::new('slug'),
            TextField::new('description'),
            NumberField::new('price'),
            AssociationField::new('categories')
                ->autocomplete()
                // ->setQueryBuilder(
                //     fn (QueryBuilder $queryBuilder) => 
                //     $queryBuilder->getEntityManager()
                //     ->getRepository(Categories::class)
                //     ->findSubCategories()
                // )
                ,
            NumberField::new('stock'),
            DateField::new('created_at'),
            CollectionField::new('images')
                ->setEntryIsComplex(true)
                ->useEntryCrudForm(ImagesCrudController::class)
        ];
    }
}
