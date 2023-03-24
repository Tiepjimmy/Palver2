import WarehouseAcc from "@/models/warehouse/warehouse";

class Warehouse extends WarehouseAcc {
    apiGroup() {
        return "inv-warehouse";
    }
}

export default Warehouse;
