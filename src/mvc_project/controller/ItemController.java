/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package mvc_project.controller;

import java.util.ArrayList;
import mvc_project.dto.ItemDto;
import mvc_project.model.ItemModel;

/**
 *
 * @author kithruV
 */
public class ItemController {
    
    private ItemModel itemModel = new ItemModel();
    
    public String saveItem(ItemDto itemDto) throws Exception{
        return itemModel.saveItem(itemDto);
    }
    
    public String updateItem(ItemDto itemDto) throws Exception{
        return itemModel.updateItem(itemDto);
    }
    
    public String deleteItem(String itemId) throws Exception{
        return itemModel.deleteItem(itemId);
    }
    
    public ItemDto searchItem(String itemId) throws Exception{
        return itemModel.searchItem(itemId);
    }
    
    public ArrayList<ItemDto> getAllItem() throws Exception{
        return itemModel.getAllItem();
    }
    
}
