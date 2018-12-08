 class PlatformUtils {
    /**
     * @returns {boolean}
     */
    static isBrowser() {
        return typeof window !== 'undefined';
    }

    /**
     * @return {boolean}
     */
    static isNodeJs() {
        return !PlatformUtils.isBrowser() && typeof process === 'object' && typeof require === 'function';
    }

    /**
     * @returns {boolean}
     */
    static supportsWebRTC() {
        let RTCPeerConnection = PlatformUtils.isBrowser() ? (window.RTCPeerConnection || window.webkitRTCPeerConnection) : null;
        return !!RTCPeerConnection;
    }

    /**
     * @returns {boolean}
     */
    static isOnline() {
        return (!PlatformUtils.isBrowser() || !('onLine' in window.navigator)) || window.navigator.onLine;
    }
}
    class SerialBuffer extends Uint8Array {
        /**
         * @param {*} bufferOrArrayOrLength
         */
        constructor(bufferOrArrayOrLength) {
            super(bufferOrArrayOrLength);
            this._view = new DataView(this.buffer);
            this._readPos = 0;
            this._writePos = 0;
        }

        /**
         * @param {number} start
         * @param {number} end
         * @return {Uint8Array}
         */
        subarray(start, end) {
            return ArrayUtils.subarray(this, start, end);
        }

        /** @type {number} */
        get readPos() {
            return this._readPos;
        }

        /** @type {number} */
        set readPos(value) {
            if (value < 0 || value > this.byteLength) throw `Invalid readPos ${value}`;
            this._readPos = value;
        }

        /** @type {number} */
        get writePos() {
            return this._writePos;
        }

        /** @type {number} */
        set writePos(value) {
            if (value < 0 || value > this.byteLength) throw `Invalid writePos ${value}`;
            this._writePos = value;
        }

        /**
         * Resets the read and write position of the buffer to zero.
         * @returns {void}
         */
        reset() {
            this._readPos = 0;
            this._writePos = 0;
        }

        /**
         * @param {number} length
         * @return {Uint8Array}
         */
        read(length) {
            const value = this.subarray(this._readPos, this._readPos + length);
            this._readPos += length;
            return new Uint8Array(value);
        }

        /**
         * @param {*} array
         */
        write(array) {
            this.set(array, this._writePos);
            this._writePos += array.byteLength;
        }

        /**
         * @return {number}
         */
        readUint8() {
            return this._view.getUint8(this._readPos++);
        }

        /**
         * @param {number} value
         */
        writeUint8(value) {
            this._view.setUint8(this._writePos++, value);
        }

        /**
         * @return {number}
         */
        readUint16() {
            const value = this._view.getUint16(this._readPos);
            this._readPos += 2;
            return value;
        }

        /**
         * @param {number} value
         */
        writeUint16(value) {
            this._view.setUint16(this._writePos, value);
            this._writePos += 2;
        }

        /**
         * @return {number}
         */
        readUint32() {
            const value = this._view.getUint32(this._readPos);
            this._readPos += 4;
            return value;
        }

        /**
         * @param {number} value
         */
        writeUint32(value) {
            this._view.setUint32(this._writePos, value);
            this._writePos += 4;
        }

        /**
         * @return {number}
         */
        readUint64() {
            const value = this._view.getUint32(this._readPos) * Math.pow(2, 32) + this._view.getUint32(this._readPos + 4);
            if (!NumberUtils.isUint64(value)) throw new Error('Malformed value');
            this._readPos += 8;
            return value;
        }

        /**
         * @param {number} value
         */
        writeUint64(value) {
            if (!NumberUtils.isUint64(value)) throw new Error('Malformed value');
            this._view.setUint32(this._writePos, Math.floor(value / Math.pow(2, 32)));
            this._view.setUint32(this._writePos + 4, value);
            this._writePos += 8;
        }

        /**
         * @return {number}
         */
        readVarUint() {
            const value = this.readUint8();
            if (value < 0xFD) {
                return value;
            } else if (value === 0xFD) {
                return this.readUint16();
            } else if (value === 0xFE) {
                return this.readUint32();
            } else /*if (value === 0xFF)*/ {
                return this.readUint64();
            }
        }

        /**
         * @param {number} value
         */
        writeVarUint(value) {
            if (!NumberUtils.isUint64(value)) throw new Error('Malformed value');
            if (value < 0xFD) {
                this.writeUint8(value);
            } else if (value <= 0xFFFF) {
                this.writeUint8(0xFD);
                this.writeUint16(value);
            } else if (value <= 0xFFFFFFFF) {
                this.writeUint8(0xFE);
                this.writeUint32(value);
            } else {
                this.writeUint8(0xFF);
                this.writeUint64(value);
            }
        }

        /**
         * @param {number} value
         * @returns {number}
         */
        static varUintSize(value) {
            if (!NumberUtils.isUint64(value)) throw new Error('Malformed value');
            if (value < 0xFD) {
                return 1;
            } else if (value <= 0xFFFF) {
                return 3;
            } else if (value <= 0xFFFFFFFF) {
                return 5;
            } else {
                return 9;
            }
        }

        /**
         * @return {number}
         */
        readFloat64() {
            const value = this._view.getFloat64(this._readPos);
            this._readPos += 8;
            return value;
        }

        /**
         * @param {number} value
         */
        writeFloat64(value) {
            this._view.setFloat64(this._writePos, value);
            this._writePos += 8;
        }

        /**
         * @param {number} length
         * @return {string}
         */
        readString(length) {
            const bytes = this.read(length);
            return BufferUtils.toAscii(bytes);
        }

        /**
         * @param {string} value
         * @param {number} length
         */
        writeString(value, length) {
            if (StringUtils.isMultibyte(value) || value.length !== length) throw 'Malformed value/length';
            const bytes = BufferUtils.fromAscii(value);
            this.write(bytes);
        }

        /**
         * @param {number} length
         * @return {string}
         */
        readPaddedString(length) {
            const bytes = this.read(length);
            let i = 0;
            while (i < length && bytes[i] !== 0x0) i++;
            const view = new Uint8Array(bytes.buffer, bytes.byteOffset, i);
            return BufferUtils.toAscii(view);
        }

        /**
         * @param {string} value
         * @param {number} length
         */
        writePaddedString(value, length) {
            if (StringUtils.isMultibyte(value) || value.length > length) throw 'Malformed value/length';
            const bytes = BufferUtils.fromAscii(value);
            this.write(bytes);
            const padding = length - bytes.byteLength;
            this.write(new Uint8Array(padding));
        }

        /**
         * @return {string}
         */
        readVarLengthString() {
            const length = this.readUint8();
            if (this._readPos + length > this.length) throw 'Malformed length';
            const bytes = this.read(length);
            return BufferUtils.toAscii(bytes);
        }

        /**
         * @param {string} value
         */
        writeVarLengthString(value) {
            if (StringUtils.isMultibyte(value) || !NumberUtils.isUint8(value.length)) throw new Error('Malformed value');
            const bytes = BufferUtils.fromAscii(value);
            this.writeUint8(bytes.byteLength);
            this.write(bytes);
        }

        /**
         * @param {string} value
         * @returns {number}
         */
        static varLengthStringSize(value) {
            if (StringUtils.isMultibyte(value) || !NumberUtils.isUint8(value.length)) throw new Error('Malformed value');
            return /*length*/ 1 + value.length;
        }
    }

    class BufferUtils {
        /**
         * @param {*} buffer
         * @return {string}
         */
        static toAscii(buffer) {
            return String.fromCharCode.apply(null, new Uint8Array(buffer));
        }

        /**
         * @param {string} string
         * @return {Uint8Array}
         */
        static fromAscii(string) {
            const buf = new Uint8Array(string.length);
            for (let i = 0; i < string.length; ++i) {
                buf[i] = string.charCodeAt(i);
            }
            return buf;
        }

        static _codePointTextDecoder(u8) {
            if (typeof TextDecoder === 'undefined') throw new Error('TextDecoder not supported');
            if (BufferUtils._ISO_8859_15_DECODER === null) throw new Error('TextDecoder does not supprot iso-8859-15');
            if (BufferUtils._ISO_8859_15_DECODER === undefined) {
                try {
                    BufferUtils._ISO_8859_15_DECODER = new TextDecoder('iso-8859-15');
                } finally {
                    BufferUtils._ISO_8859_15_DECODER = null;
                }
            }
            return BufferUtils._ISO_8859_15_DECODER.decode(u8)
                .replace('€', '¤').replace('Š', '¦').replace('š', '¨').replace('Ž', '´')
                .replace('ž', '¸').replace('Œ', '¼').replace('œ', '½').replace('Ÿ', '¾');
        }

        static _tripletToBase64(num) {
            return BufferUtils._BASE64_LOOKUP[num >> 18 & 0x3F] + BufferUtils._BASE64_LOOKUP[num >> 12 & 0x3F] + BufferUtils._BASE64_LOOKUP[num >> 6 & 0x3F] + BufferUtils._BASE64_LOOKUP[num & 0x3F];
        }

        static _base64encodeChunk(u8, start, end) {
            let tmp;
            const output = [];
            for (let i = start; i < end; i += 3) {
                tmp = ((u8[i] << 16) & 0xFF0000) + ((u8[i + 1] << 8) & 0xFF00) + (u8[i + 2] & 0xFF);
                output.push(BufferUtils._tripletToBase64(tmp));
            }
            return output.join('');
        }

        static _base64fromByteArray(u8) {
            let tmp;
            const len = u8.length;
            const extraBytes = len % 3; // if we have 1 byte left, pad 2 bytes
            let output = '';
            const parts = [];
            const maxChunkLength = 16383; // must be multiple of 3

            // go through the array every three bytes, we'll deal with trailing stuff later
            for (let i = 0, len2 = len - extraBytes; i < len2; i += maxChunkLength) {
                parts.push(BufferUtils._base64encodeChunk(u8, i, (i + maxChunkLength) > len2 ? len2 : (i + maxChunkLength)));
            }

            // pad the end with zeros, but make sure to not forget the extra bytes
            if (extraBytes === 1) {
                tmp = u8[len - 1];
                output += BufferUtils._BASE64_LOOKUP[tmp >> 2];
                output += BufferUtils._BASE64_LOOKUP[(tmp << 4) & 0x3F];
                output += '==';
            } else if (extraBytes === 2) {
                tmp = (u8[len - 2] << 8) + (u8[len - 1]);
                output += BufferUtils._BASE64_LOOKUP[tmp >> 10];
                output += BufferUtils._BASE64_LOOKUP[(tmp >> 4) & 0x3F];
                output += BufferUtils._BASE64_LOOKUP[(tmp << 2) & 0x3F];
                output += '=';
            }

            parts.push(output);

            return parts.join('');
        }

        /**
         * @param {*} buffer
         * @return {string}
         */
        static toBase64(buffer) {
            if (PlatformUtils.isNodeJs()) {
                return new Buffer(buffer).toString('base64');
            } else if (typeof TextDecoder !== 'undefined' && BufferUtils._ISO_8859_15_DECODER !== null) {
                try {
                    return btoa(BufferUtils._codePointTextDecoder(new Uint8Array(buffer)));
                } catch (e) {
                    // Disabled itself
                }
            }

            return BufferUtils._base64fromByteArray(new Uint8Array(buffer));
        }

        /**
         * @param {string} base64
         * @return {SerialBuffer}
         */
        static fromBase64(base64) {
            return new SerialBuffer(Uint8Array.from(atob(base64), c => c.charCodeAt(0)));
        }

        /**
         * @param {*} buffer
         * @return {string}
         */
        static toBase64Url(buffer) {
            return BufferUtils.toBase64(buffer).replace(/\//g, '_').replace(/\+/g, '-').replace(/=/g, '.');
        }

        /**
         * @param {string} base64
         * @return {SerialBuffer}
         */
        static fromBase64Url(base64) {
            return new SerialBuffer(Uint8Array.from(atob(base64.replace(/_/g, '/').replace(/-/g, '+').replace(/\./g, '=')), c => c.charCodeAt(0)));
        }

        /**
         * @param {Uint8Array} buf
         * @param {string} [alphabet] Alphabet to use
         * @return {string}
         */
        static toBase32(buf, alphabet = BufferUtils.BASE32_ALPHABET.NIMIQ) {
            let shift = 3,
                carry = 0,
                byte, symbol, i, res = '';

            for (i = 0; i < buf.length; i++) {
                byte = buf[i];
                symbol = carry | (byte >> shift);
                res += alphabet[symbol & 0x1f];

                if (shift > 5) {
                    shift -= 5;
                    symbol = byte >> shift;
                    res += alphabet[symbol & 0x1f];
                }

                shift = 5 - shift;
                carry = byte << shift;
                shift = 8 - shift;
            }

            if (shift !== 3) {
                res += alphabet[carry & 0x1f];
            }

            while (res.length % 8 !== 0 && alphabet.length === 33) {
                res += alphabet[32];
            }

            return res;
        }

        /**
         * @param {string} base32
         * @param {string} [alphabet] Alphabet to use
         * @return {Uint8Array}
         */
        static fromBase32(base32, alphabet = BufferUtils.BASE32_ALPHABET.NIMIQ) {
            const charmap = [];
            alphabet.toUpperCase().split('').forEach((c, i) => {
                if (!(c in charmap)) charmap[c] = i;
            });

            let symbol, shift = 8,
                carry = 0,
                buf = [];
            base32.toUpperCase().split('').forEach((char) => {
                // ignore padding
                if (alphabet.length === 33 && char === alphabet[32]) return;

                symbol = charmap[char] & 0xff;

                shift -= 5;
                if (shift > 0) {
                    carry |= symbol << shift;
                } else if (shift < 0) {
                    buf.push(carry | (symbol >> -shift));
                    shift += 8;
                    carry = (symbol << shift) & 0xff;
                } else {
                    buf.push(carry | symbol);
                    shift = 8;
                    carry = 0;
                }
            });

            if (shift !== 8 && carry !== 0) {
                buf.push(carry);
            }

            return new Uint8Array(buf);
        }

        /**
         * @param {*} buffer
         * @return {string}
         */
        static toHex(buffer) {
            let hex = '';
            for (let i = 0; i < buffer.length; i++) {
                const code = buffer[i];
                hex += BufferUtils.HEX_ALPHABET[code >>> 4];
                hex += BufferUtils.HEX_ALPHABET[code & 0x0F];
            }
            return hex;
        }

        /**
         * @param {string} hex
         * @return {SerialBuffer}
         */
        static fromHex(hex) {
            hex = hex.trim();
            if (!StringUtils.isHexBytes(hex)) return null;
            return new SerialBuffer(Uint8Array.from(hex.match(/.{2}/g) || [], byte => parseInt(byte, 16)));
        }

        /**
         * @template T
         * @param {T} a
         * @param {*} b
         * @return {T}
         */
        static concatTypedArrays(a, b) {
            const c = new(a.constructor)(a.length + b.length);
            c.set(a, 0);
            c.set(b, a.length);
            return c;
        }

        /**
         * @param {*} a
         * @param {*} b
         * @return {boolean}
         */
        static equals(a, b) {
            if (a.length !== b.length) return false;
            const viewA = new Uint8Array(a);
            const viewB = new Uint8Array(b);
            for (let i = 0; i < a.length; i++) {
                if (viewA[i] !== viewB[i]) return false;
            }
            return true;
        }

        /**
         * @param {*} a
         * @param {*} b
         * @return {number} -1 if a is smaller than b, 1 if a is larger than b, 0 if a equals b.
         */
        static compare(a, b) {
            if (a.length < b.length) return -1;
            if (a.length > b.length) return 1;
            for (let i = 0; i < a.length; i++) {
                if (a[i] < b[i]) return -1;
                if (a[i] > b[i]) return 1;
            }
            return 0;
        }

        /**
         * @param {Uint8Array} a
         * @param {Uint8Array} b
         * @return {Uint8Array}
         */
        static xor(a, b) {
            const res = new Uint8Array(a.byteLength);
            for (let i = 0; i < a.byteLength; ++i) {
                res[i] = a[i] ^ b[i];
            }
            return res;
        }
    }
    BufferUtils.BASE64_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
    BufferUtils.BASE32_ALPHABET = {
        RFC4648: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567=',
        RFC4648_HEX: '0123456789ABCDEFGHIJKLMNOPQRSTUV=',
        NIMIQ: '0123456789ABCDEFGHJKLMNPQRSTUVXY'
    };
    BufferUtils.HEX_ALPHABET = '0123456789abcdef';
    BufferUtils._BASE64_LOOKUP = [];
    for (let i = 0, len = BufferUtils.BASE64_ALPHABET.length; i < len; ++i) {
        BufferUtils._BASE64_LOOKUP[i] = BufferUtils.BASE64_ALPHABET[i];
    }
    /**
     * @abstract
     */
    class Serializable {
        /**
         * @param {Serializable} o
         * @return {boolean}
         */
        equals(o) {
            return o instanceof Serializable && BufferUtils.equals(this.serialize(), o.serialize());
        }

        /**
         * @param {Serializable} o
         * @return {number} negative if this is smaller than o, positive if this is larger than o, zero if equal.
         */
        compare(o) {
            return BufferUtils.compare(this.serialize(), o.serialize());
        }

        hashCode() {
            return this.toBase64();
        }

        /**
         * @abstract
         * @param {SerialBuffer} [buf]
         */
        serialize(buf) {}

        /**
         * @return {string}
         */
        toString() {
            return this.toBase64();
        }

        /**
         * @return {string}
         */
        toBase64() {
            return BufferUtils.toBase64(this.serialize());
        }

        /**
         * @return {string}
         */
        toHex() {
            return BufferUtils.toHex(this.serialize());
        }
    }


    class Address extends Serializable {
        /**
         * @param {Address} o
         * @returns {Address}
         */
        static copy(o) {
            if (!o) return o;
            const obj = new Uint8Array(o._obj);
            return new Address(obj);
        }

        /**
         * @param {Hash} hash
         * @returns {Address}
         */
        static fromHash(hash) {
            return new Address(hash.subarray(0, Address.SERIALIZED_SIZE));
        }

        constructor(arg) {
            super();
            if (!(arg instanceof Uint8Array)) throw new Error('Primitive: Invalid type');
            if (arg.length !== Address.SERIALIZED_SIZE) throw new Error('Primitive: Invalid length');
            this._obj = arg;
        }

        /**
         * Create Address object from binary form.
         * @param {SerialBuffer} buf Buffer to read from.
         * @return {Address} Newly created Account object.
         */
        static unserialize(buf) {
            return new Address(buf.read(Address.SERIALIZED_SIZE));
        }

        /**
         * Serialize this Address object into binary form.
         * @param {?SerialBuffer} [buf] Buffer to write to.
         * @return {SerialBuffer} Buffer from `buf` or newly generated one.
         */
        serialize(buf) {
            buf = buf || new SerialBuffer(this.serializedSize);
            buf.write(this._obj);
            return buf;
        }

        subarray(begin, end) {
            return this._obj.subarray(begin, end);
        }

        /**
         * @type {number}
         */
        get serializedSize() {
            return Address.SERIALIZED_SIZE;
        }

        /**
         * @param {Serializable} o
         * @return {boolean}
         */
        equals(o) {
            return o instanceof Address &&
                super.equals(o);
        }

        static fromString(str) {
            try {
                return Address.fromUserFriendlyAddress(str);
            } catch (e) {
                return false;
            }

            try {
                return Address.fromHex(str);
            } catch (e) {
                return false;
            }

            try {
                return Address.fromBase64(str);
            } catch (e) {
                return false
            }

            throw new Error('Invalid address format');
        }

        /**
         * @param {string} base64
         * @return {Address}
         */
        static fromBase64(base64) {
            return new Address(BufferUtils.fromBase64(base64));
        }

        /**
         * @param {string} hex
         * @return {Address}
         */
        static fromHex(hex) {
            return new Address(BufferUtils.fromHex(hex));
        }

        /**
         * @param {string} str
         * @return {Address}
         */
        static fromUserFriendlyAddress(str) {
            str = str.replace(/ /g, '');
            if (str.substr(0, 2).toUpperCase() !== Address.CCODE) {
                throw new Error('Invalid Address: Wrong country code');
            }
            if (str.length !== 36) {
                throw new Error('Invalid Address: Should be 36 chars (ignoring spaces)');
            }
            if (Address._ibanCheck(str.substr(4) + str.substr(0, 4)) !== 1) {
                throw new Error('Invalid Address: Checksum invalid');
            }
            return new Address(BufferUtils.fromBase32(str.substr(4)));
        }

        static _ibanCheck(str) {
            const num = str.split('').map((c) => {
                const code = c.toUpperCase().charCodeAt(0);
                return code >= 48 && code <= 57 ? c : (code - 55).toString();
            }).join('');
            let tmp = '';

            for (let i = 0; i < Math.ceil(num.length / 6); i++) {
                tmp = (parseInt(tmp + num.substr(i * 6, 6)) % 97).toString();
            }

            return parseInt(tmp);
        }

        /**
         * @param {boolean} [withSpaces]
         * @return {string}
         */
        toUserFriendlyAddress(withSpaces = true) {
            const base32 = BufferUtils.toBase32(this.serialize());
            // eslint-disable-next-line prefer-template
            const check = ('00' + (98 - Address._ibanCheck(base32 + Address.CCODE + '00'))).slice(-2);
            let res = Address.CCODE + check + base32;
            if (withSpaces) res = res.replace(/.{4}/g, '$& ').trim();
            return res;
        }
    }
    Address.CCODE = 'NQ';
    Address.SERIALIZED_SIZE = 20;
    Address.HEX_SIZE = 40;
    Address.NULL = new Address(new Uint8Array(Address.SERIALIZED_SIZE));
    Address.CONTRACT_CREATION = new Address(new Uint8Array(Address.SERIALIZED_SIZE));