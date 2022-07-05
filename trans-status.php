<?php
<script>
    public function update_status()
    {
        $id_transaksi = $this->input->post('kt');
        $status = $this->input->post('stt');
        $tgl_keluar = date('Y-m-d');
        
        if ($status == "Baru" OR $status == "Pencucian" OR $status == "Setrika" $status == "Lipat") {
            $this->m_transaksi->update_status($id_transaksi, $status);
        }else{
            $this->m_transaksi->update_status1($id_transaksi, $status, $tgl_keluar);
        }
    }
</script>
?>