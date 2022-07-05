<?php
<script>
    public function update_status($id_transaksi, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('id_transaksi', $id_transaksi);
        $this->db->update('transaksi');
    }
    public function update_status1 ($id_transaksi, $status, $tgl_keluar)
    {
        
        $this->db->set('status', $status);
        $this->db->set('tgl_keluar', $tgl_keluar);
        $this->db->where('id_transaksi', $id_transaksi);
        $this->db->update('transaksi');
    }
</script>
?>