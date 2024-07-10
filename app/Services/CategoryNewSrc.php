<?php
namespace App\Services;

use App\Models\CategoryNew;

class CategoryNewSrc
{
    // Lấy ra id con thuộc thằng cha nó
    public function getAllChildrenIds($parentId)
    {
        $category = CategoryNew::find($parentId);
        $allChildren = $this->getChildren($category);

        return $allChildren->pluck('id')->toArray();
    }

    private function getChildren($category, &$children = [])
    {
        foreach ($category->children as $child) {
            $children[] = $child;
            $this->getChildren($child, $children);
        }
        return collect($children);
    }

    // tìm ra id của thằng cha parent_id = 0
    public function getRootParentCategory($categoryId)
    {
        $category = CategoryNew::find($categoryId);
        if ($category) {
            return $this->findRootParentCategory($category);
        }

        return null;
    }

    private function findRootParentCategory($category)
    {
        if ($category->parent_id === 0) {
            return $category;
        }

        return $this->findRootParentCategory($category->parent);
    }
}
