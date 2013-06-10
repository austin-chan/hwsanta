//
//  SetupViewController.m
//  HopingForAWish
//
//  Created by Austin Chan on 11/25/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "SetupViewController.h"
#import "TheNavigationController.h"
#import "GameState.h"

@interface SetupViewController (){

    BOOL isRequesting;
    
    UIButton *selectedGradeButton;
    NSString *selectedGrade;
    UIButton *selectedGenderButton;
    NSString *selectedGender;
    NSString *first;
    NSString *last;
    
    NSMutableData *responseData;
}

@end

@implementation SetupViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.title = @"Setup";
    [self.navigationItem setLeftBarButtonItem:[[UIBarButtonItem alloc] initWithCustomView:[UIView new]]];
    self.activityView.hidden = YES;
    [self prepTheBackground];
    //[self prepTheTitleBackground];
    [self prepButtons];
	// Do any additional setup after loading the view.
}

- (void)prepTheBackground{
    UIColor *backgroundColor = [[UIColor alloc] initWithPatternImage:[UIImage imageNamed:@"debut_light.png"]];
    self.view.backgroundColor = backgroundColor;
}
- (void)prepTheTitleBackground{
    UIColor *backgroundColor = [[UIColor alloc] initWithPatternImage:[UIImage imageNamed:@"redLinen.png"]];
    self.topTitle.backgroundColor = backgroundColor;
}
- (void)prepButtons{
    //White Button
    UIImage *greyButton = [[UIImage imageNamed:@"greyButton.png"] resizableImageWithCapInsets:UIEdgeInsetsMake(18, 18, 18, 18)];
    UIImage *greyButtonPressed = [[UIImage imageNamed:@"greyButtonHighlight.png"] resizableImageWithCapInsets:UIEdgeInsetsMake(18,18,18,18)];
    
    [self.submitButton setBackgroundImage:greyButton forState:UIControlStateNormal];
    [self.submitButton setBackgroundImage:greyButtonPressed forState:UIControlStateHighlighted];
}


// Make sure the field 
- (BOOL)textFieldShouldReturn:(UITextField *)textField{
    [textField resignFirstResponder];
    return YES;
}


- (IBAction)sophomoreSelected:(id)sender {
    selectedGrade = @"Sophomore";
    [self selectGrade:(UIButton *)sender];
}

- (IBAction)juniorSelected:(id)sender {
    selectedGrade = @"Junior";
    [self selectGrade:(UIButton *)sender];
}

- (IBAction)seniorSelected:(id)sender {
    selectedGrade = @"Senior";
    [self selectGrade:(UIButton *)sender];
}
- (void)selectGrade:(UIButton *)activeButton{
    if(selectedGradeButton != nil){
        selectedGradeButton.backgroundColor = [UIColor colorWithRed:85.0/255 green:85.0/255 blue:85.0/255 alpha:1];
    }
    activeButton.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"greenLinen.png"]];
    selectedGradeButton = activeButton;
}



- (IBAction)maleSelected:(id)sender {
    selectedGender = @"Male";
    [self selectGender:(UIButton *)sender];
}
- (IBAction)femaleSelected:(id)sender {
    selectedGender = @"Female";
    [self selectGender:(UIButton *)sender];
}
- (void)selectGender:(UIButton *)activeButton{
    if(selectedGenderButton != nil){
        selectedGenderButton.backgroundColor = [UIColor colorWithRed:49.0/255 green:74.0/255 blue:135.0/255 alpha:1];
    }
    activeButton.backgroundColor = [UIColor colorWithRed:70.0/255 green:120.0/255 blue:71.0/255 alpha:1];
    selectedGenderButton = activeButton;
}



- (IBAction)submitSelected:(id)sender {
    if(isRequesting) return;
    [self submitForm];
}

// Submit the form to the server, if server says no, then use UIAlertView
- (void)submitForm{
    first = self.firstNameField.text;
    last = self.lastNameField.text;
    //selectedGrade (NSString *)
    //selectedGender (int)
    if([first length] == 0 || [last length] == 0 || [selectedGrade length] == 0 || [selectedGender length] == 0){
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Incomplete" message:@"Please complete all the fields before proceeding" delegate:self cancelButtonTitle:@"Ok" otherButtonTitles:nil];
        [alert show];
        return;
    }else{
        isRequesting = YES;
        NSString *userid = [[GameState sharedGameState] getUserID];

        NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/setup.php?userid=%@&first=%@&last=%@&grade=%@&gender=%@", userid, first, last, selectedGrade, selectedGender];
        NSURLRequest *request = [NSURLRequest requestWithURL:[NSURL URLWithString:[sendString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]]];
        
        self.activityView.hidden = NO;
        [self.activityView startAnimating];
        
        [[NSURLConnection alloc] initWithRequest:request delegate:self];
    }
}












- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response
{
    responseData = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    [responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    isRequesting = NO;
    self.activityView.hidden = YES;
    [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not connect to server" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    isRequesting = NO;
    self.activityView.hidden = YES;
    NSString *response = [[NSString alloc] initWithData:responseData encoding: NSASCIIStringEncoding];
    if([response isEqualToString:@"error"]){
        return;
    }
    
    [(TheNavigationController *)[self navigationController] doneSetup];
}
@end
