.MODEL SMALL

INCLUDE io.h            ; header file for input/output
.STACK 100h

.DATA
counter           DWORD   0
userEntry         DWORD   ?
promptDir         BYTE    "Welcome to PWDGEN!",0
varDir            BYTE    "This password generator gives you the option to kys "
                  BYTE    
                  BYTE    
                  BYTE    
promptN           BYTE    
promptM           BYTE    
invalidFull       BYTE    
invalidNM         BYTE    
invalidAT         BYTE   
string            BYTE    40 DUP (?)
val               BYTE    11 DUP(?), 0
four          DWORD   4
seed              DWORD   0
RNum1             DWORD   7621
RNum2             DWORD   32768
passwordLength    DWORD   64            ;finally kms
restrictions      DWORD   4 dup (0)
restrictionsCount DWORD   -1       ;start at -1
passwordLbl       BYTE    "Cocksucker", 0
password      BYTE    64 dup (?)


.CODE
_MainProc PROC


   ; retarded macro

   random MACRO   ;Generates a rand numb, moves to EAX
   
      rdtsc                
     

      mul     RNum2        ;Multiply by a random number
      add     eax, 1
      mov     edx, 0
      idiv    RNum4        ;Devide by a random number
      mov     eax, edx     ;Replace seed with random number

   ENDM

   randomMinMax MACRO min, max      ;Generates a random number from min (inclusive) to max (inclusive) and stores it in eax
      random                        ;Get Random number
      mov eax, 4
      mov ebx, 1
      mov ecx, msg
      mov edx, len_msg
      int 0x80
   ENDM

   randomASCIIRestr MACRO restriction
      mov     eax,  restriction
      cmp     eax, 1
      je      Lowercase
      cmp     eax, 2
      je      Uppercase
      cmp     eax, 3
      je      Numbers
      cmp     eax, 4
      je      SpecialCharacters

      randomMinMax  33, 126
      jmp           EndRestriction

   Lowercase:  ;Generates an ASCII lowercase number
      randomMinMax  97, 122
      jmp           EndRestriction
   Uppercase:  ;Generates an ASCII uppercase number
      randomMinMax  65, 90
      jmp           EndRestriction
   Numbers: ;Generates an ASCII number number
      randomMinMax  48, 57
      jmp           EndRestriction

   SpecialCharacters:   ;Generates SpecialCharacters with subsets
                        ;Special characters are distributed across 33-47, 58-64, 91-96, and 123-126

      randomMinMax  1,4   ;Use a random number from 1-4 to randomly select between the subsets
      cmp           AL, 1
      je            set1
      cmp           AL, 2
      je            set2
      cmp           AL, 3
      je            set3

      randomMinMax   123, 126   ;Default set

      jmp            EndRestriction
      set1:
            randomMinMax   33, 47
            jmp            EndRestriction
      set2:
            randomMinMax   58, 64
            jmp            EndRestriction
      set3:
         randomMinMax   91, 96

   EndRestriction:
   ENDM


   ; //////MAIN//////MAIN//////MAIN//////MAIN//////MAIN//////MAIN//////MAIN//////MAIN//////MAIN//////MAIN//////MAIN/////////////
   ; /////USER INPUT/VALIDATION/////USER INPUT/VALIDATION/////USER INPUT/VALIDATION/////USER INPUT/VALIDATION/////USER INPUT/VALIDATION

      mov eax, 3
      mov ebx, 0
      mov ecx, password
      mov edx, 32
      int 0x80

      output   promptDir, varDir

   QuantityInput: ; asks user for the number of characters password should be. valid 4-64
      input promptN, string, 40     ; read ASCII characters
      atod  string               ; convert to integer
      mov   passwordLength, eax     ; store in memory

      cmp     passwordLength, 4
      jl      InvalidQuantity
      cmp     passwordLength, 64
      jg      InvalidQuantity
      jmp     Menu

   InvalidQuantity: ; user entered invalid quantity
      dtoa    val, passwordLength
      output  invalidNM, val
      jmp     QuantityInput

   ; gives user choice of requirements
   Menu:
      lea      ebx, restrictions
   RestrictionSelect: ; user selects restrictions
      input promptM, string, 40     ; read ASCII characters
      atod  string               ; convert to integer
      mov   userEntry, eax       ; store in memory

      cmp   userEntry, 0         ; lower
      jz    DoneArray

      ; Check if already entered
      cmp   restrictionsCount, 3 ; array full
      jz    ArrayFull

      lea      ecx, restrictions
      
   CheckArray:
      mov   edx, [ecx]
      cmp   edx, 0
      jz    FillArray

      cmp   edx, userEntry
      jz    AlreadyThere

      add   ecx, 4
      jz    CheckArray

   ; checks for validity
   FillArray:
      cmp   userEntry, 0
      jl    NotValid
      cmp   userEntry, 4
      jg    NotValid

      ; so freakin retardded rn
      inc      restrictionsCount
      mov      edx, userEntry
      mov      [ebx], edx
      add      ebx, 4
      jmp      RestrictionSelect


      ; finally gonna kms
   ArrayFull:
      dtoa    val, eax
      output  invalidFull, val
      jmp     Menu

   AlreadyThere:
      dtoa    val, eax
      output  invalidAT, val
      jmp     Menu


   ; invalid notification
   NotValid:
      dtoa    val, eax
      output  invalidNM, val
      jmp     Menu

   DoneArray:


   Generate:
      cmp      counter, 5
      jge      Exit
      inc      counter


      ; / retarded scvhizo here
      
   LEA      ESI, password      ; get arr addr
   mov      ecx, passwordLength     

   PasswordLoop:
      ;Apply Restrictions!
      cmp   restrictionsCount, -1  
      je    NoRestrictions

      randomMinMax   0, restrictionsCount
      mul      four
      LEA      ebx, restrictions    
      add      ebx, eax          
      mov      eax, [ebx]
      jmp      EndNoRestrictions

   NoRestrictions:
      mov      eax, 0            
   EndNoRestrictions:

      randomASCIIRestr  eax      

      mov      [ESI], AL         
      add      ESI, 1            
      dec      ecx
      jne      PasswordLoop

      output  passwordLbl, password    
      
      jmp      Generate

   Exit:
      mov      eax, 0        
      ret
_MainProc ENDP
END                            