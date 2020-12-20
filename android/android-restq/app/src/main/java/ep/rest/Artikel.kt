package ep.rest

import java.io.Serializable

data class Artikel(
        val id: Int = 0,
        val ime: String = "",
        val avtor: String = "",
        val cena: Int = 0) : Serializable
