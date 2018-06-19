<?php

declare(strict_types=1);

/**
 * Created by IntelliJ IDEA.
 * User: Sean.Xiao<jxzsxsp@qq.com>
 * Date: 2018/6/17
 * Time: 下午4:48
 */

namespace Spider\Soyoung;


use Nette\Database\Connection;

class SoyoungItem
{

    public static function saveItemMenu1(Connection $db, $menu1) {
        $db->query("INSERT INTO lm_item", [
            "id" => $menu1->menu1_id,
            "name" => $menu1->name,
            "parent_id" => 0,
            "level" => $menu1->level,
            "name_alias" => $menu1->name_alias,
            "display_order" => $menu1->display_order,
            "img_url" => $menu1->img_url,
        ], "ON DUPLICATE KEY UPDATE", [
            "name" => $menu1->name,
            "parent_id" => 0,
            "level" => $menu1->level,
            "name_alias" => $menu1->name_alias,
            "display_order" => $menu1->display_order,
            "img_url" => $menu1->img_url,
        ]);
    }

    public static function saveItemMenu2(Connection $db, $menu2) {
        $db->query("INSERT INTO lm_item", [
            "id" => $menu2->menu2_id,
            "name" => $menu2->name,
            "parent_id" => $menu2->menu1_id,
            "level" => $menu2->level,
        ], "ON DUPLICATE KEY UPDATE", [
            "name" => $menu2->name,
            "parent_id" => $menu2->menu1_id,
            "level" => $menu2->level,
        ]);
    }

    public static function saveItem(Connection $db, $item, $parentId) {
        $db->query("INSERT INTO lm_item", [
            "id" => $item->item_id,
            "name" => $item->name,
            "parent_id" => $parentId,
            "level" => $item->level,
        ], "ON DUPLICATE KEY UPDATE", [
            "id" => $item->item_id,
            "name" => $item->name,
            "parent_id" => $parentId,
            "level" => $item->level,
        ]);
    }

    public static function saveItemGroup(Connection $db, $name) {
        $db->query("INSERT INTO lm_item_group", [
            "name" => $name,
        ], "ON DUPLICATE KEY UPDATE", [
            "name" => $name,
        ]);
    }

    public static function saveItemGroupRel(Connection $db, $itemId, $groupId) {
        $db->query("INSERT INTO lm_item_group_rel", [
            "group_id" => $groupId,
            "item_id" => $itemId,
        ], "ON DUPLICATE KEY UPDATE", [
            "group_id" => $groupId,
        ]);
    }

    public static function getItemId(Connection $db, $aliasName) {
        $id = $db->fetchField("SELECT id FROM lm_item WHERE name_alias=?", $aliasName);
        return $id;
    }

    public static function getItemGroupId(Connection $db, $name) {
        $id = $db->fetchField("SELECT id FROM lm_item_group WHERE name=?", $name);
        return $id;
    }

}