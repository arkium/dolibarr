-- ============================================================================
-- Copyright (C) 2005      Brice Davoleau <e1davole@iu-vannes.fr>
-- Copyright (C) 2005-2010 Matthieu Valleton <mv@seeschloss.org>
--
-- This program is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation; either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program. If not, see <https://www.gnu.org/licenses/>.
--
-- ============================================================================

create table llx_categorie_member
(
  fk_categorie  integer NOT NULL,
  fk_member     integer NOT NULL,
  import_key    varchar(14)
)ENGINE=innodb;
