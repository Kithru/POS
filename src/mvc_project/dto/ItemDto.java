/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package mvc_project.dto;

/**
 *
 * @author kithruV
 */
public class ItemDto {
    
    private String id;
    private String desc;
    private String pack;
    private double unitPrice;
    private int qty;

    public ItemDto(String id, String desc, String pack, double unitPrice, int qty) {
        this.id = id;
        this.desc = desc;
        this.pack = pack;
        this.unitPrice = unitPrice;
        this.qty = qty;
    }

    public String getDesc() {
        return desc;
    }
    public void setDesc (String desc){
        this.desc = desc;
    }

    public String getId() {
        return id;
    }
    public void setId (String id){
        this.id = id;
    }

    public String getPack() {
        return pack;
    }
    public void setPack (String pack){
        this.pack = pack;
    }

    public int getQty() {
        return qty;
    }
    public void setQty (int qty){
        this.qty = qty;
    }

    public double getUnitPrice() {
        return unitPrice;
    }
    public void getUnitPrice (double unitPrice){
        this.unitPrice = unitPrice;
    }
    

    @Override
    public String toString() {
        return "ItemDto{" + "id=" + id + ", desc=" + desc + ", pack=" + pack + ", unitPrice=" + unitPrice + ", qty=" + qty + '}';
    }
    



    
    
}
    

